<?php

namespace App\Services;

use App\Models\Medicine;
use App\Models\MedicineTransaction;
use Illuminate\Support\Facades\DB;
use Exception;
use Carbon\Carbon;

class MedicineService
{
    public function createMedicine(array $data): Medicine
    {
        // Calculate stock level
        $data['stock_level'] = $this->calculateStockLevel(
            (int) $data['num_of_boxes'],
            (int) $data['qty_per_boxes']
        );

        // Create the medicine record
        return Medicine::create([
            'category_id' => $data['category_id'],
            'name' => $data['name'],
            'generic_name' => $data['generic_name'],
            'manufacturer' => $data['manufacturer'],
            'description' => $data['description'],
            'tracking_number' => $data['tracking_number'],
            'delivery_date' => $data['delivery_date'],
            'manufactured_date' => $data['manufactured_date'],
            'expiry_date' => $data['expiry_date'],
            'num_of_boxes' => $data['num_of_boxes'],
            'qty_per_boxes' => $data['qty_per_boxes'],
            'unit_of_measure' => $data['unit_of_measure'],
            'source' => $data['source'],
            'stock_level' => $data['stock_level']
        ]);
    }

    private function calculateStockLevel(int $boxes, int $quantity): int
    {
        return $boxes * $quantity;
    }

    private function isExpired(Carbon $date): bool
    {
        return $date->isPast();
    }

    public function update(Medicine $medicine, array $data): Medicine
    {
        try {
            // Calculate updated stock
            $data['stock_level'] = $this->calculateStockLevel(
                (int) $data['num_of_boxes'],
                (int) $data['qty_per_boxes']
            );

            // Update the medicine record
            $medicine->update($data);

            return $medicine->fresh();
        } catch (\Exception $e) {
            throw new Exception('Failed to update medicine: ' . $e->getMessage());
        }
    }

    public function deleteMedicine(Medicine $medicine): bool
    {
        if ($medicine->transactions()->exists()) {
            throw new Exception('Cannot delete medicine with existing transactions');
        }
        return $medicine->delete();
    }

    public function forceDeleteMedicine(Medicine $medicine): bool
    {
        return DB::transaction(function () use ($medicine) {
            $medicine->transactions()->forceDelete();
            return $medicine->forceDelete();
        });
    }

    public function dispenseMedicine(array $data): MedicineTransaction
    {
        return DB::transaction(function () use ($data) {
            $medicine = Medicine::findOrFail($data['medicine_id']);

            if ($medicine->isExpired()) {
                throw new Exception('Cannot dispense expired medicine');
            }

            if (!$medicine->hasEnoughStock($data['quantity'])) {
                throw new Exception('Insufficient stock');
            }

            $transaction = MedicineTransaction::create($data);
            $medicine->updateStock($data['quantity'], 'out');

            return $transaction;
        });
    }

    public function updateTransaction(MedicineTransaction $transaction, array $data): MedicineTransaction
    {
        return DB::transaction(function () use ($transaction, $data) {
            // Revert old stock
            $transaction->revertStock();

            // Update transaction
            $transaction->update($data);

            // Update new stock
            $transaction->medicine->updateStock($data['quantity'], 'out');

            return $transaction;
        });
    }

    public function deleteTransaction(MedicineTransaction $transaction): bool
    {
        return DB::transaction(function () use ($transaction) {
            $transaction->revertStock();
            return $transaction->delete();
        });
    }

    public function forceDeleteTransaction(MedicineTransaction $transaction): bool
    {
        return DB::transaction(function () use ($transaction) {
            $transaction->revertStock();
            return $transaction->forceDelete();
        });
    }
}
