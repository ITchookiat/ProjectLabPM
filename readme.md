https://github.com/ITchookiat/Projectleasing.git
- ติดตั้งตัว xammp
    - แก้ไขไฟล์ php.ini 
        1. post_max_size=8M ->     post_max_size=10G
        2. upload_max_filesize=2M ->     upload_max_filesize=10G
        3.max_file_uploads=20 ->    max_file_uploads=100
        4.เพิ่มคำไสั่ง extension=php_pdo_sqlsrv_72_ts.dll
        5.เปิดคำสั้ง extension=pdo_odbc
        
    - เพิ่มไฟล์ php_pdo_sqlsrv_72_ts.dll ในโฟรเดอร์ Xammp/php/ext
    
- ติดตั้งตัว SQL SERVER 2017-2018
    1.ใส่รหัสเข้าใช้ ฐานข้อมูล
       User : sa
       Pass : it@Mazda12o456
       
 - ดาวโหลดโปแกรม microsoft odbc driver
     1.ตั้งค่า Protocal ในส่วนของ SQL Server Config ให้เป็น Enable ให้หมด
    

        
