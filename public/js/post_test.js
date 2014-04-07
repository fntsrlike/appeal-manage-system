$(function() {
  post_test = {}  ;
  post_test.url = "http://more.handlino.com/sentences.json?callback=?";
  post_test.str = '';
  post_test.data_obj = {};
  post_test.ctr = 1;


  post_test.run = function() {
    post_test.update_text(40,3,56,'xuzhimo', post_test.put_data);
  }

  post_test.put_data = function(data) {
      post_test.str = data;
      post_test.data_obj.p_name = "申訴人" + post_test.ctr + "號";
      post_test.data_obj.p_number = '4' + Math.floor((Math.random()*1000000000));
      post_test.data_obj.p_depart = post_test.depart[Math.floor((Math.random()*100))%45];
      post_test.data_obj.p_gyear  = 100 + Math.floor((Math.random()*10));
      post_test.data_obj.p_phone  = '09'+ Math.floor((Math.random()*100000000));
      post_test.data_obj.p_email  = 'tester' + post_test.ctr + '@test.tw';
      post_test.data_obj.e_title  = post_test.str[0].substr(0,Math.floor((Math.random()*100))%28+5);
      post_test.data_obj.e_target = post_test.str[1].substr(0,8);
      post_test.data_obj.e_place  = post_test.str[2].substr(0,8);
      post_test.data_obj.e_date   = '2014/' + (Math.floor((Math.random()*100))%12+1) + '/' + (Math.floor((Math.random()*100))%30+1);
      post_test.data_obj.e_status = Math.floor((Math.random()*10))%3+1;
      post_test.data_obj.e_content= '';
      post_test.data_obj.e_report = '';

      for (var j=3; j<30; j++) {
        post_test.data_obj.e_content += post_test.str[j];
      }
      if (post_test.data_obj.e_status == 3) {
        for (var k=30; k<35; k++) {
          post_test.data_obj.e_report  += post_test.str[k];
        }
      }

      post_test.ctr++;
      post_test.post_data(post_test.data_obj);

  };




  post_test.update_text = function(n, min, max, corpus, callback) {
    var option = {'n':n}
    option['limit']  = min + "," + max;
    option['corpus'] = corpus;

    $.getJSON(post_test.url, option, function(data) {
        post_test.put_data(data.sentences);
    });
  };

  post_test.post_data = function(post_data) {
    $.post(
        appeal.config.base_url + 'api/put_process_testing',
        post_data,
        function(data) {
            if (data.status == "true") {
              // Code..
              console.log("true");
            }
            else if (data.status == "false") {
              // Code..
              console.log("false");
              console.log(data.err_msg);
            }
            else {
              // Code..
              console.log("failed");
            }
        },
        "json"
    )
    .done(function() {
      // Code..
      console.log("Done.");
    })
    .fail(function() {
      // Code..
      console.log("Connect Failed");
    });
  }

  post_test.depart = [
     "C20" ,
     "C30" ,
     "U11" ,
     "U12" ,
     "U13" ,
     "U21" ,
     "U23" ,
     "U24" ,
     "U28" ,
     "U29" ,
     "U30G",
     "U30F",
     "U30H",
     "U31" ,
     "U32" ,
     "U33A",
     "U33B",
     "U34" ,
     "U35" ,
     "U36" ,
     "U37" ,
     "U38B",
     "U38A",
     "U39" ,
     "U40" ,
     "U42" ,
     "U43" ,
     "U44" ,
     "U51" ,
     "U52" ,
     "U53A",
     "U53B",
     "U54B",
     "U54A",
     "U56" ,
     "U60F",
     "U61B",
     "U61A",
     "U62A",
     "U62B",
     "U63" ,
     "U64A",
     "U64B",
     "U65" ,
     "U66"
  ];

});