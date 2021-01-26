<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cardetail extends Model
{
  protected $table = 'cardetails';
  protected $primaryKey = 'Buyercar_id';
  protected $fillable = ['Buyercar_id','Brand_car','Typecardetails','Groupyear_car','Year_car','Colour_car','License_car','Nowlicense_car','Mile_car','Midprice_car','Model_car',
                        'Top_car','Interest_car','Vat_car','Timeslacken_car','Pay_car','Paymemt_car','Timepayment_car','Tax_car',
                        'Taxpay_car','Totalpay1_car','Totalpay2_car','Dateduefirst_car','Insurance_car','status_car','Percent_car',
                        'Payee_car','IDcardPayee_car','Accountbrance_car','Tellbrance_car','Agent_car','Accountagent_car','Commission_car','Tellagent_car',
                        'Purchasehistory_car','Supporthistory_car','Loanofficer_car','Approvers_car','Date_Appcar','Check_car',
                        'StatusApp_car','DocComplete_car','branch_car','ManagerApp_car','DataManager_car','branchbrance_car','branchAgent_car','Note_car','Insurance_key','Salemethod_car',
                        'AccountImage_car','UserCheckAc_car','DateCheckAc_car'];

  public function Buyercardetails()
  {
    return $this->belongsTo(Buyer::class,'Buyercar_id');
  }
}
