<!--
<html>
<head>
  <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
</head>
<body>
  <table id="example">
    <thead>
      <tr><th>Sites</th></tr>
    </thead>
    <tbody>
      <tr><td>SitePoint</td></tr>
      <tr><td>Learnable</td></tr>
      <tr><td>Flippa</td></tr>
    </tbody>
  </table>
  <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
  <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
  <script>
  $(function(){
    $("#example").dataTable();
  })
  </script>
</body>
</html>
-->

<html>
<head>
  <link rel="stylesheet" type="text/css" href="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/css/jquery.dataTables.css">
</head>
<body>
<select name="name">

</select>
  <table id="example">
    <thead>
    <tr><th class="site_name">Name</th><th>Email</th><th>phone</th></tr>
    </thead>
    <tbody></tbody>
  </table>
  <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jQuery/jquery-1.8.2.min.js"></script>
  <script type="text/javascript" charset="utf8" src="http://ajax.aspnetcdn.com/ajax/jquery.dataTables/1.9.4/jquery.dataTables.min.js"></script>
  <script>
  // $(function(){
  //   $("#example").dataTable();
  // })


/*
  $("#example").dataTable({
            "aaData":[
              ["Sitepoint","http://sitepoint.com","Blog","2013-10-15 10:30:00"],
              ["Flippa","http://flippa.com","Marketplace","null"],
              ["99designs","http://99designs.com","Marketplace","null"],
              ["Learnable","http://learnable.com","Online courses","null"],
              ["Rubysource","http://rubysource.com","Blog","2013-01-10 12:00:00"]
            ],
            "aoColumnDefs":[{
                  "sTitle":"Site name"
                , "aTargets": [ "site_name" ]
            },{
                  "aTargets": [ 1 ]
                , "bSortable": false
                , "mRender": function ( url, type, full )  {
                    return  '<a href="'+url+'">' + url + '</a>';
                }
            },{
                  "aTargets":[ 3 ]
                , "sType": "date"
                , "mRender": function(date, type, full) {
                    return (full[2] == "Blog") 
                              ? new Date(date).toDateString()
                              : "N/A" ;
                }  
            }]
          });

*/

    $("#example").dataTable({
        "bServerSide": true,
        // "sAjaxSource": "http://localhost/datatable/data_source.json",
        "sAjaxSource": "http://localhost/datatable/get_user.php",
        "aoColumns": [{
          "mData":"name",
          "sTitle": "Site name"
        },{
          "mData": "email",
          "sTitle":"Email"         
        },{
          "mData": "phone",
          "sTitle":"Phone"
        }
        ]
    });


  </script>
</body>
</html>


