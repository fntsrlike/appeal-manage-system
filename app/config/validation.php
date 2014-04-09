<?php

return array(
    'form' => array(
        'store' =>array(
            'rules' =>array(
                'title'     => 'required',
                'date'      => 'required,date_format:Y/m/d',
                'place'     => 'required',
                'target'    => 'required',
                'content'   => 'required'
            ),
            'messages' =>array(
                'title.required'    => '標題為必填欄位',
                'date.required'     => '事發日期為必填欄位',
                'date.date_format'  => '事發日期請以yyyy/mm/dd的格式填寫',
                'place.required'    => '事發地點為必填欄位',
                'target.required'   => '申訴對象為必填欄位',
                'content.required'  => '申訴內容為必填欄位'
            )
        ),

        'update' =>array(
            'rules' =>array(
                'title'     => 'required',
                'date'      => 'required,date_format:Y/m/d',
                'place'     => 'required',
                'target'    => 'required',
                'content'   => 'required'
            ),
            'messages' =>array(
                'title.required'    => '標題為必填欄位',
                'date.required'     => '事發日期為必填欄位',
                'date.date_format'  => '事發日期請以yyyy/mm/dd的格式填寫',
                'place.required'    => '事發地點為必填欄位',
                'target.required'   => '申訴對象為必填欄位',
                'content.required'  => '申訴內容為必填欄位'
            )
        ),
    ),
    'register' => array(
        'rules' =>array(
            'username'  => 'required',
            'number'    => 'required',
            'department'=> 'required',
            'grade'     => 'required',
            'name'      => 'required',
            'phone'     => 'required',
            'email'     => 'required',
        ),
        'messages' =>array(
            'username.required'  => '使用者名稱讀取失敗！',
            'number.required'    => '學號讀取失敗！',
            'department.required'=> '科系讀取失敗！',
            'grade.required'     => '年級讀取失敗！',
            'name.required'      => '姓名讀取失敗！',
            'phone.required'     => '電話讀取失敗！',
            'email.required'     => '信箱讀取失敗！'
        )
    ),


);