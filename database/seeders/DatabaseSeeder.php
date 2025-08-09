<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin1234'),
            'role' => 'admin'
        ]);

        DB::table('companies')->insert([
            'name' => 'Al Asfar Technical Service LLC',
            'code' => 'ATS',
            'vatin' => 'OM1100042914',
            'address' => 'PO Box 1429 Al-khuwair P.C. 133, Sultanate of Oman',
            'phone' => '968 24499104',
            'fax' => '968 24499502',
            'mobile' => '99232631',
            'email' => 'ats@alasfaroman.com',
            'website' => 'www.alasfaroman.com',
            'bank' => 'BANK MUSCAT',
            'bank_account_no' => '0315003455920016',
            'bank_branch' => 'Madinat Al Sultan Qaboos',
            'bank_swift_code' => 'BMUSOMRXXXX',
            'logo' => 'images/ats.png',
            'signature_img' => 'images/companies/ats_signature.jpeg',
            'invoice_bg' => 'images/companies/ats_invoice_bg.jpeg'
        ]);
        DB::table('companies')->insert([
            'name' => 'International Capital Tower',
            'code' => 'ICT',
            'vatin' => 'OM1100042914',
            'address' => 'PO Box 1429 Al-khuwair P.C. 133, Sultanate of Oman',
            'phone' => '968 24499104',
            'fax' => '968 24499502',
            'mobile' => '99232631',
            'email' => 'ats@alasfaroman.com',
            'website' => 'www.alasfaroman.com',
            'bank' => 'BANK MUSCAT',
            'bank_account_no' => '0315003455920016',
            'bank_branch' => 'Madinat Al Sultan Qaboos',
            'bank_swift_code' => 'BMUSOMRXXXX',
            'logo' => 'images/ats.png',
            'signature_img' => 'images/companies/ict_signature.jpeg',
            'invoice_bg' => 'images/companies/ats_invoice_bg.jpeg'
        ]);

        DB::table('starting_invoice_nos')->insert([
            'company_id' => '1',
            'invoice_no' => '1',
            'quot_no' => '1',
            'lpo_no' => '1'
        ]);
        DB::table('starting_invoice_nos')->insert([
            'company_id' => '2',
            'invoice_no' => '1',
            'quot_no' => '1',
            'lpo_no' => '1'
        ]);


        // DB::table('document_names')->insert([
        //     'name' => 'Licence',
        //     'document_owner' => 'Equipment'
        // ]);
        // DB::table('document_names')->insert([
        //     'name' => 'Licence',
        //     'document_owner' => 'Employee'
        // ]);
        // DB::table('document_names')->insert([
        //     'name' => 'Licence',
        //     'document_owner' => 'Customer'
        // ]);

        // DB::table('equipment_categories')->insert([
        //     'name' => 'Crane'
        // ]);
        // DB::table('equipment_categories')->insert([
        //     'name' => 'Truck'
        // ]);
    }
}
