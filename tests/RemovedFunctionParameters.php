<?php
putenv('UNIQID=$uniqid');
putenv( "TZ=Europe/London");
hash_init ( 'salsa10');
hash_init ( 'salsa20');
hash_init ( 'md5');
hash_file("salsa10", __FILE__);
hash_file("md5", __FILE__);
