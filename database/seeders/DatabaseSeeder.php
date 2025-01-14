<?php

namespace Database\Seeders;

use App\Models\Approver;
use App\Models\Driver;
use App\Models\Office;
use App\Models\Vehicle;
use App\Models\User;
use File;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            "name" => "Naufal Ulinnuha",
            "email" => "admin@naufal.dev",
            "password" => bcrypt('admin'),
            "phone" => "085234006051"
        ]);

        Approver::insert([
            ["name" => "Approver 1","email" => "approver1@naufal.dev","password" => bcrypt('approver1'),"phone" => "085234006051",],
            ["name" => "Approver 2","email" => "approver2@naufal.dev","password" => bcrypt('approver2'),"phone" => "085234006051",]
        ]);
        
        $approvers = json_decode(File::get("database/data/approvers.json"));
        foreach ($approvers as $key => $value) {
            Approver::create([
                "name" => $value->name,
                "email" => $value->email,
                "password" => bcrypt('approver'),
                "phone" => $value->phone,
            ]);
        }

        $offices = json_decode(File::get("database/data/offices.json"));
        foreach ($offices as $key => $value) {
            Office::create([
                "id" => $value->id,
                "name" => $value->name,
                "address" => $value->address,
            ]);
        }

        $drivers = json_decode(File::get("database/data/drivers.json"));
        foreach ($drivers as $key => $value) {
            Driver::create([
                "office_id" => $value->office_id,
                "name" => $value->name,
                "license_number" => $value->license_number,
                "phone" => $value->phone,
            ]);
        }

        $vehicles = json_decode(File::get("database/data/vehicles.json"));
        foreach ($vehicles as $key => $value) {
            Vehicle::create([
                "id" => $value->id,
                "name" => $value->name,
                "type" => $value->type,
                "license_plate" => $value->license_plate,
                "is_owned" => $value->is_owned,
                "fuel_consumption" => $value->fuel_consumption,
                "image" => $value->id.".webp",
                "last_service" => $value->last_service,
                "next_service" => $value->next_service
            ]);
        }
    }
}
