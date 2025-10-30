<?php

namespace Database\Seeders;

use App\Models\Device;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class DevicesTableSeeder extends Seeder
{

    public function run()
    {
        $cities = [
        ['Warsaw', 52.2297, 21.0122],                  
        ['Krakow', 50.0647, 19.9450],               
        ['Lodz', 51.7592, 19.4550],               
        ['Wroclaw', 51.1079, 17.0385],                 
        ['Poznan', 52.4064, 16.9252],          
        ['Gdansk', 54.3520, 18.6466],           
        ['Szczecin', 53.4285, 14.5528],                
        ['Bydgoszcz', 53.1235, 18.0084],        
        ['Lublin', 51.2465, 22.5684],         
        ['Katowice', 50.2649, 19.0238],                
        ['Bialystok', 53.1325, 23.1688],              
        ['Czestochowa', 50.8118, 19.1203],             
        ['Radom', 51.4027, 21.1471],                
        ['Rzeszow', 50.0412, 21.9991],                 
        ['Torun', 53.0138, 18.5984],        
        ['Kielce', 50.8661, 20.6286],     
        ['Gliwice', 50.2945, 18.6714],      
        ['Olsztyn', 53.7784, 20.4801],     
        ['Zielona Gora', 51.9356, 15.5064],       
        ['Gorzow Wielkopolski', 52.7368, 15.2288],
        ['Tychy', 50.1372, 18.9846],                   
        ['Elblag', 54.1522, 19.4045],                  
        ['Plock', 52.5468, 19.7064],                   
        ['Kalisz', 51.7611, 18.0910],                  
        ];



        foreach ($cities as [$city, $lat, $lng]) {
            Device::factory()->create([
                'name' => "Device $city",
                'address' => "$city, Poland",
                'latitude' => $lat,
                'longitude' => $lng,
            ]);
        }
    }

}