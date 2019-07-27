@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <div>
                        <label>請輸入統一編號:</label>
                        <input type="text" class="companyNo" placeholder="53922216">
                    </div>
                    <div>
                        <button type="button" class="btn btn-info getData ">查詢</button>
                    </div>
                    <br>
                    <div class="show" style="display: none">
                        <label>公司名稱:</label>
                        <div class="name">
                            
                        </div>
                        <label>公司地址:</label>
                        <div class="address">
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(".getData").click(function(){
        console.log('123');
        var companyNo = $('.companyNo').val();
        console.log(companyNo);
        if (companyNo != '') {
            $.ajax({
              url: "/api/v1/company/getName",
              data: {
                Business_Accounting_NO: companyNo
              },
              success: function( result ) {
                if (result.data != null) {
                    const data =result.data[0];
                    $(".name").text(data.Company_Name);
                    $(".address").text(data.Company_Location);
                    $(".show").show();
                    Swal.fire({
                      title: '成功',
                      text: '查詢成功',
                      type: 'success',
                      confirmButtonText: '確認'
                    })
                } else {
                    Swal.fire({
                      title: '錯誤',
                      text: '查無此統一編號',
                      type: 'error',
                      confirmButtonText: '確認'
                    })
                }
                
              }
            });
        } else {
            Swal.fire({
              title: '錯誤',
              text: '請輸入統一編號',
              type: 'error',
              confirmButtonText: '確認'
            })
        }
    });
</script>
@endsection
