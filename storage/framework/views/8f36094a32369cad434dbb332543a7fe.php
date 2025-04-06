<?php $__env->startSection('main-content'); ?>

<div class="card">
    <h5 class="card-header">Add Product</h5>
    <div class="card-body">
      <form method="post" action="<?php echo e(route('product.store')); ?>" enctype="multipart/form-data">
        <?php echo e(csrf_field()); ?>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Title <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="title" placeholder="Enter title"  value="<?php echo e(old('title')); ?>" class="form-control">
          <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
          <span class="text-danger"><?php echo e($message); ?></span>
          <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="form-group">
          <label for="summary" class="col-form-label">Summary <span class="text-danger">*</span></label>
          <textarea class="form-control" id="summary" name="summary"><?php echo e(old('summary')); ?></textarea>
          <?php $__errorArgs = ['summary'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
          <span class="text-danger"><?php echo e($message); ?></span>
          <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="form-group">
          <label for="description" class="col-form-label">Description</label>
          <textarea class="form-control" id="description" name="description"><?php echo e(old('description')); ?></textarea>
          <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
          <span class="text-danger"><?php echo e($message); ?></span>
          <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>


        <div class="form-group">
          <label for="is_featured">Is Featured</label><br>
          <input type="checkbox" name='is_featured' id='is_featured' value='1' checked> Yes                        
        </div>
              

        <div class="form-group">
          <label for="cat_id">Category <span class="text-danger">*</span></label>
          <select name="cat_id" id="cat_id" class="form-control">
              <option value="">--Select any category--</option>
              <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$cat_data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value='<?php echo e($cat_data->id); ?>'><?php echo e($cat_data->title); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
        </div>

        <div class="form-group d-none" id="child_cat_div">
          <label for="child_cat_id">Sub Category</label>
          <select name="child_cat_id" id="child_cat_id" class="form-control">
              <option value="">--Select any category--</option>
              
          </select>
        </div>

        <div class="form-group">
          <label for="price" class="col-form-label">Price(₱) <span class="text-danger">*</span></label>
          <input id="price" type="number" name="price" placeholder="Enter price in Peso"  value="<?php echo e(old('price')); ?>" class="form-control">
          <?php $__errorArgs = ['price'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
          <span class="text-danger"><?php echo e($message); ?></span>
          <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div class="form-group">
          <label for="discount" class="col-form-label">Discount(%)</label>
          <input id="discount" type="number" name="discount" min="0" max="100" placeholder="Enter discount"  value="<?php echo e(old('discount')); ?>" class="form-control">
          <?php $__errorArgs = ['discount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
          <span class="text-danger"><?php echo e($message); ?></span>
          <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="form-group">
          <label for="size">Bottle Size</label>
          <select name="size[]" class="form-control selectpicker" multiple data-live-search="true">
              <option value="">--Select bottle size--</option>
              <option value="5ml">5ml (Travel Size)</option>
              <option value="10ml">10ml (Travel Size)</option>
              <option value="30ml">30ml (1.0 fl oz)</option>
              <option value="50ml">50ml (1.7 fl oz)</option>
              <option value="75ml">75ml (2.5 fl oz)</option>
              <option value="100ml">100ml (3.4 fl oz)</option>
              <option value="120ml">120ml (4.0 fl oz)</option>
              <option value="test_2ml">2ml Tester</option>
              <option value="test_5ml">5ml Tester</option>
          </select>
        </div>

        <div class="form-group">
          <label for="brand_id">Brand</label>
          

          <select name="brand_id" class="form-control">
              <option value="">--Select Brand--</option>
             <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <option value="<?php echo e($brand->id); ?>"><?php echo e($brand->title); ?></option>
             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </select>
        </div>

        <div class="form-group">
          <label for="condition">Condition</label>
          <select name="condition" class="form-control">
              <option value="">--Select Condition--</option>
              <option value="default">Default</option>
              <option value="new">New</option>
              <option value="hot">Hot</option>
          </select>
        </div>

        <div class="form-group">
          <label for="stock">Quantity <span class="text-danger">*</span></label>
          <input id="quantity" type="number" name="stock" min="0" placeholder="Enter quantity"  value="<?php echo e(old('stock')); ?>" class="form-control">
          <?php $__errorArgs = ['stock'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
          <span class="text-danger"><?php echo e($message); ?></span>
          <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="form-group">
          <label for="inputPhoto" class="col-form-label">Photos <span class="text-danger">*</span></label>
          <div id="photos-container">
            <div class="input-group mb-3">
                <span class="input-group-btn">
                    <a id="lfm-0" data-input="thumbnail-0" data-preview="holder-0" class="btn btn-primary">
                    <i class="fa fa-picture-o"></i> Choose Photo
                    </a>
                </span>
                <input id="thumbnail-0" class="form-control" type="text" name="photo" value="">
                <span class="input-group-btn">
                    <button type="button" class="btn btn-success add-photo"><i class="fa fa-plus"></i></button>
                </span>
            </div>
            <div id="holder-0" style="margin-top:15px;max-height:100px;"></div>
          </div>
          <input type="hidden" id="photo_array" name="photos" value="">
        </div>
        
        <div class="form-group">
          <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
          <select name="status" class="form-control">
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
          </select>
          <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
          <span class="text-danger"><?php echo e($message); ?></span>
          <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="form-group mb-3">
          <button type="reset" class="btn btn-warning">Reset</button>
           <button class="btn btn-success" type="submit">Submit</button>
        </div>
      </form>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('backend/summernote/summernote.min.css')); ?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="<?php echo e(asset('backend/summernote/summernote.min.js')); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<script>
    var route_prefix = "/filemanager";
    $('#lfm').filemanager('image', {prefix: route_prefix});
    
    $(document).ready(function() {
        $('#thumbnail').on('change', function() {
            var input = $(this).val();
            var images = input.split(',');
            var holder = $('#holder');
            holder.empty();
            
            images.forEach(function(image) {
                if(image.trim()) {
                    holder.append('<img src="'+image.trim()+'" style="height:100px;width:100px;object-fit:cover;margin:5px;">');
                }
            });
        });
    });

    $(document).ready(function() {
      $('#summary').summernote({
        placeholder: "Write short description.....",
          tabsize: 2,
          height: 100
      });
    });

    $(document).ready(function() {
      $('#description').summernote({
        placeholder: "Write detail description.....",
          tabsize: 2,
          height: 150
      });
    });
    // $('select').selectpicker();

</script>

<script>
    var photoCount = 1;
    var photos = [];
    
    function initFilePicker(id) {
        $(`#lfm-${id}`).filemanager('image');
        
        $(`#thumbnail-${id}`).on('change', function() {
            var input = $(this).val();
            var holder = $(`#holder-${id}`);
            holder.empty();
            
            if(input.trim()) {
                holder.append(`<img src="${input.trim()}" style="height:100px;width:100px;object-fit:cover;margin:5px;">`);
                photos.push(input.trim());
                $('#photo_array').val(JSON.stringify(photos));
            }
        });
    }

    initFilePicker(0);

    $('.add-photo').click(function() {
        var newInput = `
            <div class="input-group mb-3">
                <span class="input-group-btn">
                    <a id="lfm-${photoCount}" data-input="thumbnail-${photoCount}" data-preview="holder-${photoCount}" class="btn btn-primary">
                    <i class="fa fa-picture-o"></i> Choose Photo
                    </a>
                </span>
                <input id="thumbnail-${photoCount}" class="form-control" type="text" name="photo" value="">
                <span class="input-group-btn">
                    <button type="button" class="btn btn-danger remove-photo" data-id="${photoCount}"><i class="fa fa-minus"></i></button>
                </span>
            </div>
            <div id="holder-${photoCount}" style="margin-top:15px;max-height:100px;"></div>
        `;
        
        $('#photos-container').append(newInput);
        initFilePicker(photoCount);
        photoCount++;
    });

    $(document).on('click', '.remove-photo', function() {
        var id = $(this).data('id');
        var photoUrl = $(`#thumbnail-${id}`).val();
        photos = photos.filter(item => item !== photoUrl);
        $('#photo_array').val(JSON.stringify(photos));
        $(this).closest('.input-group').next('div').remove();
        $(this).closest('.input-group').remove();
    });
</script>

<script>
  $('#cat_id').change(function(){
    var cat_id=$(this).val();
    // alert(cat_id);
    if(cat_id !=null){
      // Ajax call
      $.ajax({
        url:"/admin/category/"+cat_id+"/child",
        data:{
          _token:"<?php echo e(csrf_token()); ?>",
          id:cat_id
        },
        type:"POST",
        success:function(response){
          if(typeof(response) !='object'){
            response=$.parseJSON(response)
          }
          // console.log(response);
          var html_option="<option value=''>----Select sub category----</option>"
          if(response.status){
            var data=response.data;
            // alert(data);
            if(response.data){
              $('#child_cat_div').removeClass('d-none');
              $.each(data,function(id,title){
                html_option +="<option value='"+id+"'>"+title+"</option>"
              });
            }
            else{
            }
          }
          else{
            $('#child_cat_div').addClass('d-none');
          }
          $('#child_cat_id').html(html_option);
        }
      });
    }
    else{
    }
  })
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('backend.layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp_bumatay\htdocs\Perfume-Shop-main\resources\views/backend/product/create.blade.php ENDPATH**/ ?>