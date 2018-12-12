
function  studentInfo(slist,url,curr,limit){
    console.log(url)
    $.ajax({
        type:"post",
        url:url,//对应controller的URLgetInfo
        async:false,
        // dataType: 'json',
        data:{
            "curPage":curr,
            "pageSize":limit,
            "data":slist
        },
        success:successFunction
    });

}




function toPage(slist,url) {

    layui.use('laypage', function(){
        var laypage = layui.laypage;

        laypage.render({
            elem: 'demo8'
            ,count: total
            ,limit:5
            ,limits:[5,10,15]
            ,layout: ['limit', 'prev', 'page', 'next','hh']
            ,slist:slist
            // ,curr: location.hash.replace('#!fenye=', '11') //获取起始页
            // ,hash: 'curPage' //自定义hash值
            ,jump: function(obj, first){
                // console.log(obj.limit);
                //首次不执行
                if(!first){

                    studentInfo(obj.slist,url,obj.curr,obj.limit);
                }
            }

        });
    });

}

function successFunction(data){
    $("#table-data").html('');
    $("#table-data").append(data);
    total = $("#total").val();
}