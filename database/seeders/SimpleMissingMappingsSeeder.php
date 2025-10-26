<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SimpleMissingMappingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creating simple missing user mappings...');
        
        // Daftar UUID yang sering muncul di favorites tapi tidak ada di mapping
        $missingUuids = [
            'ae94e84e-0dab-4ae9-b378-c232117c4e12',
            'f9f97c06-3ebe-4598-851d-6add07e1da5b',
            '4721cfb9-e32b-4954-8c01-c578987af234',
            '57263e92-3b4b-4c02-95d7-34c68b1b200f',
            'a5360dd5-11fa-4df6-ab68-ab7aabc78b9b',
            '8f5aac8c-0ecf-4842-9b05-bdb080870b7a',
            'f44d8aba-66cc-4bfd-a2ba-64d134c7e6fd',
            '6362d086-3ef7-45d5-aee2-f936f20e94a4',
            'd682c9dc-edbf-4826-85d8-a85b752b9163',
            '85a132e9-90fb-47fb-a1bc-23fbbf393d55',
            '9df9b75a-b7a1-4f2f-9ad9-dd3671aa0d23',
            '774e868d-833b-4ae3-9c8e-868c89104675',
            'ab74dc9b-83ae-4ee3-89d7-cc2b9e124f61',
            '0e91c225-ff6f-4761-8479-42f04154ba82',
            '0feff20e-fc87-43a5-9a45-f1f818a7ed01',
            'c8f49cf7-4222-4c63-9c14-54e06bd0efbd',
            '4479c952-1417-4f3c-b03c-3a9e448a468b',
            '0daf9f3a-1025-47e3-9c19-576839cafe32',
            '741a3387-e732-4a17-88eb-d418eaebf3ab',
            '08f15a75-62ba-407d-9516-ddb90ae49764',
            '7ddacea3-56e3-4815-b70b-ec627b473b2b',
            '9f62a1f0-46aa-4eb6-b740-bd1b6a02dc36',
            '117cb2be-81e3-418c-bd37-7be3eaef643f',
            '4481495b-c5e2-411a-af21-517d05b7714a',
            '5785ba72-eb09-430e-882f-346976a72497',
            '546e361e-658e-4a44-8ce0-771f7229815c',
            '50782b36-30ff-4e94-8d45-ab40fec226da',
            '2a027fc1-c984-44a0-bc80-f718752a00ca',
            'f54b959f-9731-445a-8d46-c8211b037267',
            '0d4a6ad9-c638-459b-8eba-bdcf137ed111',
            '15dac8f7-1df9-4cee-aec0-11f13ab42743',
            'b3634c5d-244e-4fd7-a67a-bb05bacb17f6',
            '1ef37be2-9c95-4d6f-b54f-889ff69c012e',
            '9556e2e1-b193-4cd9-a6db-97acab425a05',
            'c3c44640-a2a7-43a4-b6c8-e96ac7bc2579',
            '9fbd3a87-8aba-4198-9553-6a55dc6ace84',
            '13dbe60c-0db0-4965-a815-6736dc479e16',
            '77900d68-8e4b-48ee-a632-5d67fc6e3f4b',
            'cb2daec9-8b37-4ae3-90f0-0eec2973f554',
            'bdeb1f20-e037-42a5-9053-422885151c76',
            'a3605ac0-1828-4cb0-8777-14781949dd02',
            'd396780c-2709-4114-a7d3-c8d62c08bb16',
            '70ef24dd-a4c7-47c6-bb25-56db4db639e4',
            '5f375121-6088-4d5b-8b00-d506c29712fc',
            'b06e724c-ac5d-4ec9-9aa5-2006051209f0',
            'd213df04-690b-45d4-bedc-e0fe40685a16',
            '5ee2e5eb-7f0c-488b-9627-15a72a867f11',
            '37690de9-a91f-484b-97b7-7f7aec7c38e8',
            '9a9ba37b-416b-42ba-92f5-bd183654a52f',
            'd358ae3e-7552-42db-812c-fc995ae052c6',
            'd6e6392f-3c3c-48a4-bcef-365b071c1fe8',
            '83012795-e227-46d7-97c9-35587b278348',
            'bda3ac61-278e-48f7-976d-0de4ffe6b190',
            'bff1c69a-99c6-4704-946d-79643d6607f5',
            '72921b16-12bd-47f0-a3fd-9f835e73f8ce',
            '459df877-ebdd-4f87-ae37-c8fe50400114',
            'cc4cfa79-f24f-4d02-bb5a-6070df5565d8',
            '914c384b-03e6-41c3-b19b-68f1409a2b6d',
            'be6e725e-1e1b-49f3-b8bf-a588183dcdef',
            '5b3a6932-8b68-4bc7-b5dd-9cb3c048474c',
            '57012d95-b4e9-4ecf-a2c6-90df670dbe06',
            '6d636603-3956-4eed-bc5f-315dee9052fd'
        ];
        
        $nextUserId = DB::table('users')->max('id') + 1;
        $createdCount = 0;
        
        foreach ($missingUuids as $uuid) {
            // Cek apakah UUID sudah ada di mapping
            $exists = DB::table('user_id_mapping')->where('uuid_id', $uuid)->exists();
            
            if (!$exists) {
                // Buat user dummy untuk UUID yang tidak ada
                $dummyUser = [
                    'name' => 'Migrated User ' . $nextUserId,
                    'email' => 'migrated_' . $nextUserId . '@example.com',
                    'password' => bcrypt('password'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
                
                $newUserId = DB::table('users')->insertGetId($dummyUser);
                
                // Buat mapping
                DB::table('user_id_mapping')->insert([
                    'uuid_id' => $uuid,
                    'bigint_id' => $newUserId,
                    'created_at' => now()
                ]);
                
                $this->command->info("Created mapping for UUID {$uuid} -> User ID {$newUserId}");
                $nextUserId++;
                $createdCount++;
            } else {
                $this->command->info("UUID {$uuid} already exists in mapping");
            }
        }
        
        $this->command->info("Created {$createdCount} new mappings");
    }
}
