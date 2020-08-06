$(document).ready(function () {
   $('.AlertForm').click(function (evt) {
        var Contract_buyer = $(this).data("name");
        var form = $(this).closest("form");
        
        evt.preventDefault();
        swal({
            title: `${Contract_buyer}`,
            icon: "warning",
            text: "คุณต้องการยืนยันการลบหรือไม่ ?",
            buttons: true,
            dangerMode: true,
        })
        .then((isConfirm)=>{
            // console.log(isConfirm);
            if (isConfirm) {
                swal("ลบข้อมูลสำเร็จ !", {
                    icon: "success",
                    timer: 5000,
                })
                form.submit();
            }
        });

    });
});

$(document).ready(function () {
    $('.MainPage').click(function (evt) {
         var form = $(this).closest("form");
         var _this = $(this)

         evt.preventDefault();
         swal({
            icon: "warning",
            text: "คุณต้องการกลับหน้าหลักหรือไม่ ?",
            buttons: true,
            dangerMode: true
         }).then((willDone)=>{
            if (willDone) {
               window.location.href = _this.attr('href')
            }
        });
    });
 });

 $(document).ready(function () {
    $('.DeleteImage').click(function (evt) {
         var form = $(this).closest("form");
         var _this = $(this)

         evt.preventDefault();
         swal({
            icon: "error",
            title: "คุณต้องการลบรูปหรือไม่ ?",
            text: "หากลบแล้วจะไม่สามารถดึงข้อมูลกลับมาได้อีก !",
            buttons: true,
            dangerMode: true
         }).then((willDelete)=>{
            if (willDelete) {
                swal("ลบข้อมูลสำเร็จ !", {
                    icon: "success",
                    timer: 3000,
                })
               window.location.href = _this.attr('href')
            }
        });
    });
 });
