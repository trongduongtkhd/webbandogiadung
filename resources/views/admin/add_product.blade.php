  @extends('admin_layout')
  @section('admin_content')

  <div class="row">
      <div class="col-lg-12">
          <section class="panel">
              <header class="panel-heading">
                  Thêm sản phẩm
              </header>
              <div class="panel-body">

                  @if(session('product_message'))
                  <span style="color:green;">{{ session('product_message') }}</span>
                  @endif
                  <div class="position-center">
                      <form role="form" action="{{URL::to('/save-product')}}" method="post"
                          enctype="multipart/form-data">
                          @csrf
                          <div class="form-group">
                              <label for="productName">Tên sản phẩm </label>
                              <input type="text" data-validation="length" data-validation-length="min5"
                                  data-validation-error-msg="Làm ơn điền ít nhất 5 ký tự" name="product_name"
                                  class="form-control" id="productName" placeholder="Tên danh mục sản phẩm">
                          </div>
                          <div class="form-group">
                              <label for="productPrice">Giá sản phẩm </label>
                              <input type="text" data-validation="number"
                                  data-validation-error-msg="Làm ơn điền số tiền " name="product_price"
                                  class="form-control" id="productPrice" placeholder="Tên danh mục sản phẩm">
                          </div>
                          <div class="form-group">
                              <label for="productImage">Hình ảnh sản phẩm </label>
                              <input type="file" name="product_image" class="form-control" id="productImage">
                          </div>
                          <div class="form-group">
                              <label for="ckeditor1">Mô tả sản phẩm </label>
                              <textarea style="resize:none" rows="5" class="form-control" name="product_desc"
                                  id="ckeditor1" placeholder="Mô tả sản phẩm "></textarea>
                          </div>
                          <div class="form-group">
                              <label for="productContent">Nội dung sản phẩm </label>
                              <textarea style=" resize:none " rows="5" class="form-control" name="product_content"
                                  id="productContent" placeholder="Nội dung sản phẩm "></textarea>
                          </div>
                          <div class="form-group">
                              <label for="exampleInputPassword1">Danh mục sản phẩm </label>
                              <select name="product_cate" class="form-control input-sm m-bot15">
                                  @foreach($cate_product as $key => $cate)
                                  <option value="{{$cate->category_id}}">{{$cate->category_name}}</option>

                                  @endforeach
                              </select>
                          </div>
                          <div class="form-group">
                              <label for="exampleInputPassword1">Thương hiệu </label>
                              <select name="product_brand" class="form-control input-sm m-bot15">
                                  @foreach($brand_product as $key => $brand)
                                  <option value="{{$brand->brand_id}}">{{$brand->brand_name}}</option>
                                  @endforeach
                              </select>
                          </div>
                          <div class="form-group">
                              <label for="exampleInputPassword1">Hiển thị </label>
                              <select name="product_status" class="form-control input-sm m-bot15">
                                  <option value="0">Ẩn</option>
                                  <option value="1">Hiển thị</option>

                              </select>
                          </div>

                          <button type="submit" name="add_product" class="btn btn-info">Thêm sản phẩm </button>
                      </form>
                  </div>

              </div>
          </section>

      </div>
      @endsection