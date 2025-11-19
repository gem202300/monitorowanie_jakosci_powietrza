<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Спочатку створюємо базові сутності
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
        ]);

        $this->call(UserSeeder::class);


        $this->call([
            DevicesTableSeeder::class,
            ParametersTableSeeder::class,
        ]);

        $this->call([
            DeviceParametersTableSeeder::class,
            
        ]);

        $this->call(NotificationSeeder::class);


        $this->call(DeviceRepairSeeder::class);

        $this->call([
            MeasurementsTableSeeder::class,
            MeasurementValuesTableSeeder::class,
        ]);

       
    }
}