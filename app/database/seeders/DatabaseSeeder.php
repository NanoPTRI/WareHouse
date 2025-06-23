<?php

namespace Database\Seeders;

use App\Models\DataPengiriman;
use App\Models\Pallet;
use App\Models\PalletCode;
use App\Models\PalletCustom;
use App\Models\TempPallet;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

       User::insert(
           [
               'id' => Str::uuid(),
               'username' => 'lala',
               'password' => Hash::make('123456'),
               'role' => 'administrator',
               'id_employe' => 'IT',
           ]
       );
//        Pallet::insert(
//            [
//                'id' => Str::uuid(),
//                'id_inventori' => "TRI522CXX-XXLRI100-1",
//                'id_custom_pallet' => null,
//                'id_data_pengiriman' =>'10940d0e-0d5a-4571-aed8-96f55cdfa490' ,
//                'checker2' => null
//            ]
//        );

//        Pallet::insert(
//            [
//                [
//                    'id' => Str::uuid(),
//                    'id_inventori' => "TRI522CXX-XXLRI100-1",
//                    'id_data_pengiriman' =>'d5013b5a-b1b7-4fa7-9a5f-9f0f8cd389e1' ,
//                    'checker2' => null
//                ],
//               [
//                'id' => Str::uuid(),
//                'id_inventori' => "TRI522EXX-XXLRI100-1",
//                'id_data_pengiriman' =>'d5013b5a-b1b7-4fa7-9a5f-9f0f8cd389e1' ,
//                'checker2' => null
//            ],[
//                'id' => Str::uuid(),
//                'id_inventori' => "TRI712TXX-XXLRI100-1",
//                'id_data_pengiriman' => 'd5013b5a-b1b7-4fa7-9a5f-9f0f8cd389e1',
//                'checker2' => null
//            ],[
//                'id' => Str::uuid(),
//                'id_inventori' => "BRB712NXX-SULRI100-1",
//                'id_data_pengiriman' => 'd5013b5a-b1b7-4fa7-9a5f-9f0f8cd389e1',
//                'checker2' => null
//            ],[
//                'id' => Str::uuid(),
//                'id_inventori' => "HRESA15CX-XX2XX100-8",
//                'id_data_pengiriman' => 'd5013b5a-b1b7-4fa7-9a5f-9f0f8cd389e1',
//                'checker2' => null
//            ],
//            ]
//        );
//
//        DataPengiriman::where('id','d5013b5a-b1b7-4fa7-9a5f-9f0f8cd389e1')->update([
//            'expedisi' => 'expedisi1',
//            'supir' => 'supir1',
//            'no_mobil' => 'kb3322ddm',
//            'no_loading' => 'leddk',
//            'no_cont' => 'nocont23ddkk43',
//            'mulai' => now()->format('H:i:s'),
//            'sampai' => now()->format('H:i:s'),
//           'checker1' => now()
//        ]);


        $data = [];

        for ($i = 41; $i <= 60; $i++) {
            $code = 'PL' . str_pad($i, 4, '0', STR_PAD_LEFT);
            $data[] = [
                'id' => Str::uuid(),
                'code' => $code,
                'name' => 'pallet' . $i,
            ];
        }

        PalletCode::insert($data);


        // TempPallet::insert([
        //     [
        //         'id_pallet' => "503febb6-96c5-4fdb-8cd3-0bcbfa807990",
        //         'id_pallet_code' => 'cf3a5afc-0ba9-49fc-a7ca-cd00c1a51425'
        //     ], [
        //         'id_pallet' => "0ba9e08f-1eaf-4ab3-b2e1-750a11219f17",
        //         'id_pallet_code' => '3ef63b60-f495-4103-a112-47b054c7b495'
        //     ], [
        //         'id_pallet' => "1ec973a4-2f03-4984-b3f7-02c27c07d1b2",
        //         'id_pallet_code' => '60ff10d0-8d02-4e49-9f83-0b8a43a78b8b'
        //     ], [
        //         'id_pallet' => "9531aba9-0015-4340-9013-5b1a42c74547",
        //         'id_pallet_code' => '1f9846be-30d7-45c7-80c6-123e68c82ee4'
        //     ], [
        //         'id_pallet' => "b7f11323-da24-4f0f-a4ab-f61f08b6b6d3",
        //         'id_pallet_code' => '78574008-90e9-4d25-857c-4d155caae153'
        //     ],
        // ]);
//        TempPallet::insert([
//            [
//                'id_pallet' => "503febb6-96c5-4fdb-8cd3-0bcbfa807990",
//                'id_pallet_code' => 'cf3a5afc-0ba9-49fc-a7ca-cd00c1a51425'
//            ], [
//                'id_pallet' => "0ba9e08f-1eaf-4ab3-b2e1-750a11219f17",
//                'id_pallet_code' => '3ef63b60-f495-4103-a112-47b054c7b495'
//            ], [
//                'id_pallet' => "1ec973a4-2f03-4984-b3f7-02c27c07d1b2",
//                'id_pallet_code' => '60ff10d0-8d02-4e49-9f83-0b8a43a78b8b'
//            ], [
//                'id_pallet' => "9531aba9-0015-4340-9013-5b1a42c74547",
//                'id_pallet_code' => '1f9846be-30d7-45c7-80c6-123e68c82ee4'
//            ], [
//                'id_pallet' => "b7f11323-da24-4f0f-a4ab-f61f08b6b6d3",
//                'id_pallet_code' => '78574008-90e9-4d25-857c-4d155caae153'
//            ],
//        ]);
//
//
//        Pallet::insert(
//            [
//                [
//                    'id' => Str::uuid(),
//                    'id_inventori' => "TRI301SXX-XXLRI100-1",
//                    'id_data_pengiriman' =>'15c299bc-ad93-492f-9374-4d49a72cfd5e' ,
//                    'checker2' => null
//                ],
//               [
//                'id' => Str::uuid(),
//                'id_inventori' => "TRI522AXX-XXLRI100-1",
//                'id_data_pengiriman' =>'15c299bc-ad93-492f-9374-4d49a72cfd5e' ,
//                'checker2' => null
//            ],[
//                'id' => Str::uuid(),
//                'id_inventori' => "TRI712BGX-XXLRI100-1",
//                'id_data_pengiriman' => '15c299bc-ad93-492f-9374-4d49a72cfd5e',
//                'checker2' => null
//            ],[
//                'id' => Str::uuid(),
//                'id_inventori' => "TRI712GAX-WXLRI100-1",
//                'id_data_pengiriman' => '15c299bc-ad93-492f-9374-4d49a72cfd5e',
//                'checker2' => null
//            ],[
//                'id' => Str::uuid(),
//                'id_inventori' => "TRI712TXX-XXLRI100-1",
//                'id_data_pengiriman' => '15c299bc-ad93-492f-9374-4d49a72cfd5e',
//                'checker2' => null
//            ],[
//                'id' => Str::uuid(),
//                'id_inventori' => "TRI712TGX-XXLRI100-1",
//                'id_data_pengiriman' => '15c299bc-ad93-492f-9374-4d49a72cfd5e',
//                'checker2' => null
//            ],[
//                'id' => Str::uuid(),
//                'id_inventori' => "TRI712GAX-OBLRI100-8",
//                'id_data_pengiriman' => '15c299bc-ad93-492f-9374-4d49a72cfd5e',
//                'checker2' => null
//            ],[
//                'id' => Str::uuid(),
//                'id_inventori' => null,
//                'id_data_pengiriman' => '15c299bc-ad93-492f-9374-4d49a72cfd5e',
//                'checker2' => null
//            ],
//            ]
//        );

//        PalletCustom::insert([
//            [
//                'id' => Str::uuid(),
//                'id_inventori'=> 'TRI301SXX-XXLRI100-1',
//                'qty' => 20,
//                'id_pallet' => 'e8fa5aef-24c3-4727-9142-46beded028f7',
//            ],  [
//                'id' => Str::uuid(),
//                'id_inventori'=> 'TRI522AXX-XXLRI100-1',
//                'qty' => 10,
//                'id_pallet' => 'e8fa5aef-24c3-4727-9142-46beded028f7',
//            ],[
//                'id' => Str::uuid(),
//                'id_inventori'=> 'TRI712TGX-XXLRI100-1',
//                'qty' => 7,
//                'id_pallet' => 'e8fa5aef-24c3-4727-9142-46beded028f7',
//            ],[
//                'id' => Str::uuid(),
//                'id_inventori'=> 'TRI712TXX-XXLRI100-1',
//                'qty' => 5,
//                'id_pallet' => 'e8fa5aef-24c3-4727-9142-46beded028f7',
//            ],
//        ]);


//        TempPallet::insert([
//            [
//                'id_pallet' => "0817bc0f-b121-49bb-8cc5-0f99c0ba7af7",
//                'id_pallet_code' => 'cf3a5afc-0ba9-49fc-a7ca-cd00c1a51425'
//            ], [
//                'id_pallet' => "4e28b0cd-abd5-4a6c-8577-5075f8f02c32",
//                'id_pallet_code' => '3ef63b60-f495-4103-a112-47b054c7b495'
//            ], [
//                'id_pallet' => "28fb78cd-6366-491d-ae6f-7eccbf65af23",
//                'id_pallet_code' => '60ff10d0-8d02-4e49-9f83-0b8a43a78b8b'
//            ], [
//                'id_pallet' => "9f76bb79-43f6-4dea-a5a7-eb706d9e8558",
//                'id_pallet_code' => '1f9846be-30d7-45c7-80c6-123e68c82ee4'
//            ], [
//                'id_pallet' => "2306fda0-f67c-4c07-acc4-61a89c2e456f",
//                'id_pallet_code' => '78574008-90e9-4d25-857c-4d155caae153'
//            ],[
//                'id_pallet' => "30459ea3-0340-4500-8e53-75f75c46a16c",
//                'id_pallet_code' => '44d8bf01-c80e-4517-aa1b-8ea766ab673e'
//            ],[
//                'id_pallet' => "02b166f3-5e5d-4dfd-81a6-d38fd21a6c52",
//                'id_pallet_code' => '3aecee6f-0c20-454d-ae93-46caad90cfde'
//            ],[
//                'id_pallet' => "e8fa5aef-24c3-4727-9142-46beded028f7",
//                'id_pallet_code' => '3cc5e266-1aef-457e-a03f-ee7f9f2ea946'
//            ],
//        ]);
    }
}






