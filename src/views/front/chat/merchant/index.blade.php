@include('laravel-chat-front::common.header')

<div class=" container">
    <form method="post" action="/merchant/index" class="form_request" data-fn="saveMerchant">
        @csrf
        <div class="form-group">
            <div>名称</div>
            <input type="text" name="name" class="form-control" value="{{$res['merchant']->name?:''}}" />
        </div>
        <div class="form-group">
            <button class="btn-default  " type="submit">保存</button>
        </div>
    </form>
</div>
<script>
    function saveMerchant(res) {
        if(!res.code) {
            location.href = res.data.redirect
        }else if(res.code===11000){
            for(var item in res.data){
                let str = ''
                res.data[item].forEach((elem, index)=>{
                    str = str+elem+'<br>'
                })
                let obj = $('#login input[name="'+item+'"]');
                obj.removeClass('is-valid').addClass('is-invalid');
                obj.next('.invalid-feedback').html(str);
            }
        }else{
            alert_msg(res)
        }
    }
</script>
@include('laravel-chat-front::common.footer')
