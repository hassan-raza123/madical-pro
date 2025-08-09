<?php 

use App\Models\Documents;
use Carbon\Carbon;


function get_expired_docs()
{
    $now_date = Carbon::now()->addDays(10)->format('Y-m-d H:i:s');
    $now_date = date_create($now_date);
    date_add($now_date,date_interval_create_from_date_string("5 hours"));
    $now_date = date_format($now_date,"Y-m-d H:i:s");
    $docs = Documents::with(['doc_name', 'equipment'])
            ->where('doc_owner_name', '=', 'Employee')
            ->orWhere('doc_owner_name', '=', 'Equipment')->get();

    $expired_docs = [];

    foreach ($docs as $key => $doc) {
        $expired_date = $doc->expiry_date;
        $timestamp_now = strtotime($now_date);
        $timestamp_exp = strtotime($expired_date);

        if(($timestamp_now - $timestamp_exp) > 0 ) {
            $temp_doc = $doc;
            $exp_date_str = $expired_date." 00:00:00";
            $datetime_exp = new DateTime($exp_date_str);
            $datetime_now = new DateTime($now_date);
            $diff = $datetime_exp->diff($datetime_now);
            
            $temp_doc['expired'] = [
                'years' => $diff->y,
                'months' => $diff->m,
                'days' => $diff->d,
                'hours' => $diff->h,
                'minutes' => $diff->i
            ];
            array_push($expired_docs, $temp_doc);
        }

        $doc->issue_date = date("d-m-Y", strtotime($doc->issue_date));
        $doc->expiry_date = date("d-m-Y", strtotime($doc->expiry_date));

    }

    return $expired_docs;
}

function get_expired_equipment_docs()
{
    $documents = get_expired_docs();
    $docs = [];
    foreach ($documents as $doc) {
        if ($doc->doc_owner_name == 'Equipment') {
            array_push($docs, $doc);
        }
    }
    return $docs;
}

function get_expired_employee_docs()
{
    $documents = get_expired_docs();
    $docs = [];
    foreach ($documents as $doc) {
        if ($doc->doc_owner_name == 'Employee') {
            array_push($docs, $doc);
        }
    }
    return $docs;
}