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
        return DB::transaction(function () use ($data) {
            // Format dates properly
            $data['manufactured_date'] = Carbon::parse($data['manufactured_date'])->format('Y-m-d');
            $data['delivery_date'] = Carbon::parse($data['delivery_date'])->format('Y-m-d');
            $data['expiry_date'] = Carbon::parse($data['expiry_date'])->format('Y-m-d');

            // Calculate initial stock
            $data['current_stock'] = $this->calculateInitialStock(
                (int) $data['number_of_boxes'], 
                (int) $data['quantity_per_boxes']
            );

            // Create the medicine record
            $medicine = Medicine::create([
                'category_id' => $data['category_id'],
                'name' => $data['name'],
                'generic_name' => $data['generic_name'],
                'manufacturer' => $data['manufacturer'],
                'description' => $data['description'],
                'tracking_number' => $data['tracking_number'],
                'delivery_date' => $data['delivery_date'],
                'manufactured_date' => $data['manufactured_date'], 
                'expiry_date' => $data['expiry_date'],
                'number_of_boxes' => $data['number_of_boxes'],
                'quantity_per_boxes' => $data['quantity_per_boxes'],
                'source' => $data['source'],
                'current_stock' => $data['current_stock']
            ]);

            if (!$medicine) {
                throw new Exception('Failed to create medicine record');
            }

            return $medicine;
        });
    }

    private function calculateInitialStock(int $boxes, int $quantity): int
    {
        $total = $boxes * $quantity;
        if ($total <= 0) {
            throw new Exception('Initial stock must be greater than 0');
        }
        return $total;
    }

    private function isExpired(Carbon $date): bool
    {
        return $date->isPast();
    }

    public function updateMedicine(Medicine $medicine, array $data): Medicine
    {
        return DB::transaction(function () use ($medicine, $data) {
            try {
                // Format dates properly
                $data['manufactured_date'] = Carbon::parse($data['manufactured_date'])->startOfDay();
                $data['delivery_date'] = Carbon::parse($data['delivery_date'])->startOfDay();
                $data['expiry_date'] = Carbon::parse($data['expiry_date'])->endOfDay();

                // Calculate updated stock
                $data['current_stock'] = $this->calculateInitialStock(
                    (int) $data['number_of_boxes'],
                    (int) $data['quantity_per_boxes']
                );

                // Update the medicine record
                $medicine->update($data);

                return $medicine->fresh();
            } catch (\Exception $e) {
                throw new Exception('Failed to update medicine: ' . $e->getMessage());
            }
        });
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