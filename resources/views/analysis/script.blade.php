<script>

    function addCommas(nStr){
       nStr += '';
       x = nStr.split('.');
       x1 = x[0];
       x2 = x.length > 1 ? '.' + x[1] : '';
       var rgx = /(\d+)(\d{3})/;
       while (rgx.test(x1)) {
         x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
      return x1 + x2;
    }

    function income(){
      var num11 = document.getElementById('Beforeincome').value;
      var num1 = num11.replace(",","");
      var num22 = document.getElementById('Afterincome').value;
      var num2 = num22.replace(",","");
      var num33 = document.getElementById('incomeSP2').value;
      var num3 = num33.replace(",","");
      var num44 = document.getElementById('incomeSP').value;
      var num4 = num44.replace(",","");
      document.form1.Beforeincome.value = addCommas(num1);
      document.form1.Afterincome.value = addCommas(num2);
      document.form1.incomeSP2.value = addCommas(num3);
      document.form1.incomeSP.value = addCommas(num4);
    }

    function mile(){
      var num11 = document.getElementById('Milecar').value;
      var num1 = num11.replace(",","");
      var num22 = document.getElementById('Midpricecar').value;
      var num2 = num22.replace(",","");
      document.form1.Milecar.value = addCommas(num1);
      document.form1.Midpricecar.value = addCommas(num2);
    }

    function calculate(){
      var typedetail = document.getElementById('Typecardetail').value;
      var year = document.getElementById('Yearcar').value;

        if(year >= 2015 && year <= 2020){
          var groupyear = '2015 - 2020';
        }
        else if(year >= 2013 && year <= 2014){
          if(typedetail == 'รถกระบะ' || typedetail == 'รถเก๋ง/7ที่นั่ง'){
            var groupyear = '2012 - 2014';
          }else{
            var groupyear = '2013 - 2014';
          }
        }
        else if(year == 2012){
          if(typedetail == 'รถกระบะ' || typedetail == 'รถเก๋ง/7ที่นั่ง'){
            var groupyear = '2012 - 2014';
          }else{
            var groupyear = '2010 - 2012';
          }
        }
        else if(year >= 2010 && year <= 2011){
          if(typedetail == 'รถกระบะ' || typedetail == 'รถเก๋ง/7ที่นั่ง'){
            var groupyear = '2010 - 2011';
          }else{
            var groupyear = '2010 - 2012';
          }
        }
        else if(year >= 2009){
          if(typedetail == 'รถกระบะ' || typedetail == 'รถเก๋ง/7ที่นั่ง'){
            var groupyear = '2009';
          }else{
            var groupyear = '2008 - 2009';
          }
        }
        else if(year >= 2008){
          if(typedetail == 'รถกระบะ' || typedetail == 'รถเก๋ง/7ที่นั่ง'){
            var groupyear = '2008';
          }else{
            var groupyear = '2008 - 2009';
          }
        }
        else if(year >= 2007){
          if(typedetail == 'รถกระบะ' || typedetail == 'รถเก๋ง/7ที่นั่ง'){
            var groupyear = '2007';
          }else{
            var groupyear = '2006 - 2007';
          }
        }
        else if(year >= 2006){
          if(typedetail == 'รถกระบะ' || typedetail == 'รถเก๋ง/7ที่นั่ง'){
            var groupyear = '2006';
          }else{
            var groupyear = '2006 - 2007';
          }
        }
        else if(year >= 2005){
          if(typedetail == 'รถกระบะ'){
            var groupyear = '2003 - 2005';
          }else if(typedetail == 'รถเก๋ง/7ที่นั่ง'){
            var groupyear = '2005';
          }else{
            var groupyear = '2004 - 2005';
          }
        }
        else if(year >= 2004){
          if(typedetail == 'รถกระบะ'){
            var groupyear = '2003 - 2005';
          }else if(typedetail == 'รถเก๋ง/7ที่นั่ง'){
            var groupyear = '2004';
          }else{
            var groupyear = '2004 - 2005';
          }
        }
        else if(year >= 2003){
          if(typedetail == 'รถกระบะ'){
            var groupyear = '2003 - 2005';
          }else{
            var groupyear = '2003';
          }
        }
        else{
              groupyear = '-';
        }

      document.form1.Groupyearcar.value = groupyear;
    }

    function calculate2(){
        var Settopcar = document.getElementById('Topcar').value;
        var Topcar = Settopcar.replace(",","");
        var Setinterest = document.getElementById('Interestcar').value;
        var Setfee = document.getElementById('Processfee').value;
        var Timelack = document.getElementById('Timeslackencar').value;

          var fee = (Setfee/100)/1;
          var capital = parseFloat(Topcar) + (parseFloat(Topcar)*parseFloat(fee));
          var interest = ((Setinterest/100)/1) * 12;
          var process = (parseFloat(capital) + (parseFloat(capital) * parseFloat(interest) * (Timelack / 12))) / Timelack;

          var total_sum = total_pay * Timelack;
          var profit = total_sum - capital;

          var str = process.toString();
          var setstring = str.split(".", 1);
          var pay = parseInt(setstring);
          var total_pay = Math.ceil(pay/10)*10;
          var total_sum = total_pay * Timelack;
          var profit = total_sum - capital;

          // var total_pay_ori = test+".00";
          // var total_pay_ori = process;
          // var total_pay_new = Math.ceil(process/10)*10;

            document.form1.Topcar.value = addCommas(Topcar);
            document.form1.Totalfee.value = addCommas(capital.toFixed(2));

          if(Timelack != ''){
            // document.form1.Paycar_ori.value = addCommas(total_pay_ori.toFixed(3));
            // document.form1.Paycar_new.value = addCommas(total_pay_new.toFixed(2));

            document.form1.Paycar.value = addCommas(total_pay.toFixed(2));
            document.form1.Totalpay1car.value = addCommas(total_sum.toFixed(2));
            document.form1.Profit.value = addCommas(profit.toFixed(2));

          }
    }

    function commission(){
          var num11 = document.getElementById('Commissioncar').value;
          var num1 = num11.replace(",","");
          var input = document.getElementById('Agentcar').value;
          var Subtstr = input.split("");
          var Setstr = Subtstr[0];
          if (Setstr[0] == "*") {
            var result = num1;
          }else {
            if(num1 > 999){
              if(num11 == ''){
                var num11 = 0;
              }else{
                var sumCom = (num1*0.015);
                var result = num1 - sumCom;
              }
            }else{
            var result = num1;
            }
          }
          
          var resultCom = parseFloat(result);
          if(!isNaN(num1)){
          document.form1.Commissioncar.value = addCommas(num1);
          document.form1.commitPrice.value =  addCommas(resultCom.toFixed(2));
          }
    }

    function balance2(){
          var Settopcar = document.getElementById('Topcar').value;
          var Topcar = Settopcar.replace(",","");
          var Setfee = document.getElementById('Processfee').value;
          var SetactPrice = document.getElementById('actPrice').value;
          var actPrice = SetactPrice.replace(",","");
          var SetcloseAccountPrice = document.getElementById('closeAccountPrice').value;
          var closeAccountPrice = SetcloseAccountPrice.replace(",","");
          var SetP2Price = document.getElementById('P2Price').value;
          var P2Price = SetP2Price.replace(",","");
            var fee = (Setfee/100)/1;
            var capital = parseFloat(Topcar)*parseFloat(fee);
            var Totalcapital = parseFloat(Topcar) + (parseFloat(Topcar)*parseFloat(fee));
            var TotalPrice = parseFloat(capital) + parseFloat(actPrice) + parseFloat(closeAccountPrice) + parseFloat(P2Price);
            var TotalBalance = parseFloat(Totalcapital) - parseFloat(TotalPrice);

          if(Totalfee != ''){
            document.form1.actPrice.value = addCommas(actPrice);
            document.form1.P2Price.value = addCommas(P2Price);
            document.form1.closeAccountPrice.value = addCommas(closeAccountPrice);
            document.form1.totalkPrice.value = addCommas(TotalPrice.toFixed(2));
            document.form1.balancePrice.value = addCommas(TotalBalance.toFixed(2));
          }
          else if(actPrice != '' || closeAccountPrice != '' || P2Price != '')
          {
            document.form1.totalkPrice.value = addCommas(TotalPrice.toFixed(2));
          }
    }

    function percent(){
      var num11 = document.getElementById('Midpricecar').value;
      var num1 = num11.replace(",","");
      var num22 = document.getElementById('Topcar').value;
      var num2 = num22.replace(",","");
      var percentt = (num2/num1) * 100;
      var result1 = percentt;
        document.form1.Topcar.value = addCommas(num2);
        if(num1 != ''){
          document.form1.Percentcar.value = result1.toFixed(0);
        }

    }


</script>