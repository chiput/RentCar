<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

use App\Model\CheckOut;
use App\Model\Reskasirku;
use App\Model\Spakasir;
use App\Model\Storekasir;

class Accjurnaldetail extends Model
{
	
    protected $table = 'accjurnaldetails';
    
    public $timestamps = false;

    public function account()
    {
        return $this->hasOne('App\Model\Account', 'id', 'accounts_id');
    }

    public function accjurnal()
    {
        return $this->belongsTo('App\Model\Accjurnal', 'id', 'accjurnals_id');
    }

    public function pendapatan($date,$status)
    {
        $convert = explode('-', $date);
        $convert = strlen($convert[0]);
        if($convert < 4){
            $date = $this->convert_date($date);
        }

        $pisah = explode("-", $date);

        $year = $pisah[0];
        $month = $pisah[1];

        $total = 0;

        //Harian
        if($status==1){
            // total pendapatan jurnal
            $checkouts = CheckOut::where('checkout_date','=',$date)->get();
            foreach ($checkouts as $checkout) {
                $total = $total + $checkout['total'];
            }
            // total pendapatan restoran kasir
            $kasirs = Reskasirku::where('tanggal','=',$date)->get();
            foreach ($kasirs as $kasir) {
                $total = $total + $kasir['tunai'];
            }
            // total pendapatan spa kasir
            $spa = Spakasir::where('tanggal','=',$date)->get();
            foreach ($spa as $spa) {
                $total = $total + $spa['tunai'];
            }
            // total pendatapan store kasir
            $store = Storekasir::where('tanggal','=',$date)->get();
            foreach ($store as $store) {
                $total = $total + $store['total'];
            }

        // Bulanan
        } else if($status==2){
            // total pendapatan jurnal
            $checkouts = CheckOut::selectRaw("MONTH(checkout_date) as month, SUM(total) as total")
                                ->whereRaw("YEAR(checkout_date) =".$year)
                                ->whereRaw("MONTH(checkout_date) =".$month)
                                ->groupBy('month')->get();

            foreach ($checkouts as $checkout) {
                $total = $total + $checkout['total'];
            }
            // total pendapatan restoran kasir
            $kasirs = Reskasirku::selectRaw("MONTH(tanggal) as month, SUM(tunai) as total")
                                ->whereRaw("YEAR(tanggal) =".$year)
                                ->whereRaw("MONTH(tanggal) =".$month)
                                ->groupBy('month')->get();
            foreach ($kasirs as $kasir) {
                $total = $total + $kasir['total'];
            }
            // total pendapatan spa kasir
            $spa = Spakasir::selectRaw("MONTH(tanggal) as month, SUM(tunai) as total")
                                ->whereRaw("YEAR(tanggal) =".$year)
                                ->whereRaw("MONTH(tanggal) =".$month)
                                ->groupBy('month')->get();
            foreach ($spa as $spa) {
                $total = $total + $spa['total'];
            }
            // total pendatapan store kasir
            $store = Storekasir::selectRaw("MONTH(tanggal) as month, SUM(total) as total")
                                ->whereRaw("YEAR(tanggal) =".$year)
                                ->whereRaw("MONTH(tanggal) =".$month)
                                ->groupBy('month')->get();
            foreach ($store as $store) {
                $total = $total + $store['total'];
            }
        }

        return $total;
    }

    public function pengeluaran($date,$status)
    {
        $convert = explode('-', $date);
        $convert = strlen($convert[0]);
        if($convert < 4){
            $date = $this->convert_date($date);
        }

        $pisah = explode("-", $date);

        $year = $pisah[0];
        $month = $pisah[1];

        $total = 0;

        if($status==1){
            $pengeluaran = Accjurnaldetail::join('accjurnals','accjurnals.id','=','accjurnaldetails.accjurnals_id')
                                ->join('accounts','accounts.id','=','accjurnaldetails.accounts_id')
                                ->join('accheaders','accounts.accheaders_id','=','accheaders.id')
                                ->join('accgroups','accheaders.accgroups_id','=','accgroups.id')
                                ->selectRaw('SUM(accjurnaldetails.debet) as nominal, accjurnaldetails.*, accounts.name as jurname')
                                ->where("accjurnals.tanggal","=",$date)
                                ->where('accgroups.id','=',9)
                                ->where('accjurnals.posted','=','POSTED')
                                ->groupBy('accjurnals.tanggal')
                                ->get();
        } else if($status==2){
            $pengeluaran = Accjurnaldetail::join('accjurnals','accjurnals.id','=','accjurnaldetails.accjurnals_id')
                                ->join('accounts','accounts.id','=','accjurnaldetails.accounts_id')
                                ->join('accheaders','accounts.accheaders_id','=','accheaders.id')
                                ->join('accgroups','accheaders.accgroups_id','=','accgroups.id')
                                ->selectRaw('SUM(accjurnaldetails.debet) as nominal, accjurnaldetails.*, accounts.name as jurname, MONTH(accjurnals.tanggal) as month')
                                ->whereRaw("YEAR(accjurnals.tanggal) = ".$year)
                                ->whereRaw("MONTH(accjurnals.tanggal) = ".$month)
                                ->where('accgroups.id','=',9)
                                ->where('accjurnals.posted','=','POSTED')
                                ->groupBy('month')
                                ->get();
        }

        foreach ($pengeluaran as $pengeluaran) {
            $total = $pengeluaran['nominal'];
        }

        return $total;
    }

    private function convert_date($date){
        $exp = explode('-', $date);
        if (count($exp)==3) {
            $date = $exp[2].'-'.$exp[1].'-'.$exp[0];
        }
        return $date;
    }
}
