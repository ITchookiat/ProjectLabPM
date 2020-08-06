function Inint_AJAX() {
    try { return new ActiveXObject("Msxml2.XMLHTTP");  } catch(e) {} //IE
    try { return new ActiveXObject("Microsoft.XMLHTTP"); } catch(e) {} //IE
    try { return new XMLHttpRequest();          } catch(e) {} //Native Javascript
    alert("XMLHttpRequest not supported");
    return null;
 };

 function dochange(url, action, type, year, to) {
      var req = Inint_AJAX();
      req.onreadystatechange = function () {
           if (req.readyState==4) {
                if (req.status==200) {
                     document.getElementById(to).innerHTML=req.responseText; //รับค่ากลับมา
                }
           }
      };
      req.open("GET", url+"?action="+action+"&type="+type+"&year="+year+"&showtext="+showtext); //สร้าง connection
      req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded;charset=utf-8"); // set Header
      req.send(null); //ส่งค่า

 }
