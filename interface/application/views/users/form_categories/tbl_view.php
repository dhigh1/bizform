<div class="table-responsive">
   <table class="table table-centered table-bordered table-striped dt-responsive nowrap w-100">
      <thead>
         <tr>
            <th>S.No.</th>
            <th>Name</th>
            <th>Code</th>
            <th>Created</th>
            <th>Updated</th>
            <th>Action</th>
         </tr>
      </thead>
      <tbody>
         <?php
         if (is_array($data_list) && !empty($data_list)) {
            $i = $pagination_data['slno'];
            foreach ($data_list as $datas) {
         ?>
               <tr>
                  <td><?php echo $i ?></td>
                  <td><?php echo $datas['name'] ?></td>
                  <td><?php echo $datas['code'] ?></td>
                  <td>
                     <?php echo custom_date('d-M-Y h:i A', $datas['created_at']); ?>
                     <?php if (!empty($datas['created_username'])) {
                        echo '<br>By - ' . ucwords($datas['created_username']);
                     } ?>
                  </td>
                  <td>
                     <?php if (!empty($datas['updated_at'])) {
                        echo custom_date('d-M-Y h:i A', $datas['updated_at']);
                     } else {
                        echo '---';
                     } ?>
                     <?php if (!empty($datas['updated_username'])) {
                        echo '<br>By - ' . ucwords($datas['updated_username']);
                     } ?>
                  </td>
                  <td class="table-action">
                     <a href="<?php echo base_url() ?>formbuilder#category_id=<?php echo $datas['id'] ?>&perpage=10" class="action-icon text-success" data-id="<?php echo $datas['id'] ?>"><i class="mdi mdi-eye"></i></a>
                     <a href="javascript:;" class="action-icon text-primary editData" data-id="<?php echo $datas['id'] ?>"> <i class="mdi mdi-pencil"></i></a>
                     <a href="javascript:;" class="action-icon text-danger deleteData" data-id="<?php echo $datas['id'] ?>"> <i class="mdi mdi-delete"></i></a>
                  </td>
               </tr>
            <?php $i++;
            }
         } else { ?>
            <tr>
               <td colspan="10" class="text-center">No records found...</td>
            </tr>
         <?php } ?>
      </tbody>
   </table>
</div>
<div id="page_result">
   <?php if (isset($pagination_data['pagination_links'])) {
      echo $pagination_data['pagination_links'];
   } ?>
</div>