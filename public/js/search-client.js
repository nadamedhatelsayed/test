$('#hhh').on('click',function (e){
    e.preventDefault();
    search();
});


function search(){
    var url = '/dashbord/client/search';

    $.ajax({
        type:'POST',
        url:url,
        data:   $('#search_form').serialize(),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success:function(data) {
             console.log(data)
            // console.log(data.data.user.name)
                let tableHead = '';
                let tableBody = '';

                if (data.data == null){
                    tableBody += `
                         <tr>
                            <td colspan="100%"><div class="text-center">
                            <p>لا يوجد عميل بهذا الرقم القومي</p>
                            <a class="btn btn-success" href="/dashbord/clients/create">إضافة عميل جديد</a>
                            </div></td>
                        </tr>
                     `;
                }else {
                    if (data.data.loans.length === 1 && data.data.loans[0].status === 0){
                        tableHead += `
                             <tr>
                                 <th>#</th>
                                 <th>اسم العميل</th>
                                 <th>حالة القرض</th>
                                 <th>إضافة قرض</th>
                             </tr>
                        `;

                        tableBody += `
                             <tr>
                                 <th>`+data.data.id+`</th>
                                 <th>`+data.data.user.name+`</th>
                                 <th>قرض منتهي</th>
                                 <th><a href="dashbord/loan/create"><span>تجديد القرض</span></a></th>
                             </tr>
                        `;
                    }else if (data.data.loans.length === 1 && data.data.loans[0].status === 1){
                        console.log('')
                        tableHead += `
                             <tr>
                                 <th>#</th>
                                 <th>اسم العميل</th>
                                 <th>حالة القرض</th>
                                 <th>تعديل البيانات</th>
                             </tr>
                        `;

                        tableBody += `
                             <tr>
                                 <th>`+data.data.id+`</th>
                                 <th>`+data.data.user.name+`</th>
                                 <th>تحت الفحص</th>
                                 <th>
                                    <div class="dropdown">
                                        <button class="btn btn-warning dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">تعديل</button>
                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" href="dashbord/loan/create" >بيانات العميل</a>
                                            <a class="dropdown-item" h>بيانات العميل</a>
                                        </div>
                                    </div>
                                </th>
                             </tr>
                        `;
                    } else if (data.data.loans.length === 1 && data.data.loans[0].status === 2){

                    }
                }
              $('thead').html(tableHead);
              $('tbody').html(tableBody);

        }
    });
}
