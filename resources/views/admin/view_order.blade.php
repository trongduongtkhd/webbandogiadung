  @extends('admin_layout')
  @section('admin_content')
  <div class="table-agile-info">
      <div class="panel panel-default">
          <div class="panel-heading">
              Thông tin khách hàng
          </div>
          <div class="table-responsive">
              @if(session('category_message'))
              <span style="color:green;">{{ session('category_message') }}</span>
              @endif
              <table class="table table-striped b-t b-light">
                  <thead>
                      <tr>
                          <th>Tên khách hàng </th>
                          <th>Số điện thoại </th>
                          <th style="width:30px;"></th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                          <td>{{$order_by_id->customer_name}}</td>
                          <td>{{$order_by_id->customer_phone}}</td>
                      </tr>
                  </tbody>
              </table>
          </div>
      </div>
  </div>
  <br></br>
  <div class="table-agile-info">
      <div class="panel panel-default">
          <div class="panel-heading">
              Thông tin vận chuyển
          </div>
          <div class="table-responsive">
              @if(session('category_message'))
              <span style="color:green;">{{ session('category_message') }}</span>
              @endif
              <table class="table table-striped b-t b-light">
                  <thead>
                      <tr>
                          <th>Tên người vận chuyển </th>
                          <th>Địa chỉ </th>
                          <th>Số điện thoại </th>
                          <th style="width:30px;"></th>
                      </tr>
                  </thead>
                  <tbody>
                      <tr>
                          <td>{{$order_by_id->shipping_name}}</td>
                          <td>{{$order_by_id->shipping_address}}</td>
                          <td>{{$order_by_id->shipping_phone}}</td>
                      </tr>
                  </tbody>
              </table>
          </div>
      </div>
  </div>
  <br></br>
  <div class="table-agile-info">
      <div class="panel panel-default">
          <div class="panel-heading">
              Thông tin chi tiết đơn hàng
          </div>
          <div class="table-responsive">
              @if(session('category_message'))
              <span style="color:green;">{{ session('category_message') }}</span>
              @endif
              <table class="table table-striped b-t b-light">
                  <thead>
                      <tr>
                          <th>Tên sản phẩm</th>
                          <th>Số lượng</th>
                          <th>Giá sản phẩm</th>
                          <th>Tổng tiền</th>
                          <th style="width:30px;"></th>
                      </tr>
                  </thead>
                  <tbody>

                      <tr>
                          <td>{{$order_by_id->product_name}}</td>
                          <td>{{$order_by_id->product_sales_quantity}}</td>
                          <td>{{$order_by_id->product_price}}</td>
                          <td>{{$order_by_id->product_price*$order_by_id->product_sales_quantity  }}</td>
                      </tr>

                  </tbody>
              </table>
          </div>
      </div>
  </div>
  @endsection