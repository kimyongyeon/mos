<?
    if ($p_user_id != 'toyongyeon')
        exit;

    $_zb_url = "/bbs/";
    $_zb_path = "/home/hosting_users/academysoft/www/bbs/";
    include $_zb_path."outlogin.php";   

    // ���� �˻�
    $connect=dbConn();
    $member=member_info();
    if($member[level] > 9)
    {
        Error("���ѵ� ����Դϴ�.");
    }  
    // ����� ID
    $user_id=$member[user_id];

    // �ڱⰡ ������ �ݸ� �� �� �ֵ��� ����

    // call pear init & call
    call_pear_init();
    require_once("DB.php");
    require_once("HTML/Template/IT.php");

    // Template
    $tpl = new HTML_Template_IT("/home/hosting_users/academysoft/www/apps/exam/templates");
    if(!$tpl->loadTemplatefile("exam_list_student.tpl.htm", true, true)) Error("loadTemplatefile");

    // DB ����
    $db =& DB::connect(call_pear_db_dsn());
    if (PEAR::isError($db)) {
    die($db->getMessage());
    }

    // ��ȸ
    $sql = "SELECT z.name, z.user_id  "
           ." FROM zetyx_member_table z "
          ." WHERE z.user_id = '$user_id' "
            ." AND s.CLASS_ID  = '$p_class_id' "


    $res = $db->query($sql);
    if (PEAR::isError($db)) {
    die($db->getMessage());
    }

    $ress = mysql_query($sql);  // ���ڵ� üũ

    if ($ress != 0)
    {
      // ����
      while ($res->fetchInto($row)) {
        if (!$tpl->setCurrentBlock("row")) Error("setCurrentBlock");
        $userid   = call_encrypt($user_id,$row[5]);
        $password = call_encrypt($password,$row[5]);

        $tpl->setVariable("NAME"       , $row[5]); // �̸�

        $tpl->parseCurrentBlock("row");

        // parse outter block
        if (!$tpl->parse("row")) Error("parseCurrentBlock");
      }
        // print the output
      $tpl->show();
    }
?>
