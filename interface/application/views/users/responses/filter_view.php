<input type="hidden" name="page" id="page" data-type="page" class="clearAbleFilt refine_filter" />
<div class="row">
   <div class=" col-lg-12">
      <div class="mb-2">
         <div class="app-search w-100 bg-white">
            <div class="mb-2 position-relative">
               <input type="text" class="form-control refine_filter" data-type="search" id="search" placeholder="Search..." />
               <span class="mdi mdi-magnify search-icon"></span>
            </div>
         </div>
      </div>
   </div>

   <div class="mb-2 col-lg-6">
      <label class="form-label">Candidate ID</label>
      <input type="text" class="form-control refine_filter" data-type="candidate_id" id="candidate_id">
   </div>

   <div class="col-lg-6">
      <div class="mb-2">
         <label class="form-label">Status</label>
         <select class="form-select refine_filter" data-type="bizform_candidates-status" id="sortby">
            <option data-type="bizform_candidates-status" value="">--select--</option>
            <option data-type="bizform_candidates-status" value="76">Completed</option>
            <option data-type="bizform_candidates-status" value="75">Pending</option>
            <option data-type="bizform_candidates-status" value="82">Cancelled</option>
         </select>
      </div>
   </div>

   <div class="col-lg-6">
      <div class="mb-2">
         <label class="form-label">Sort by</label>
         <select class="form-select refine_filter" data-type="sortby" id="sortby">
            <option data-type="sortby" value="">--select--</option>
            <option data-type="sortby" value="created_at">Created Date</option>
            <option data-type="sortby" value="updated_at">Updated Date</option>
            <!-- <option data-type="sortby" value="name">Name</option> -->
            <!-- <option data-type="sortby" value="customer_code">ID</option> -->
         </select>
      </div>
   </div>

   <div class="col-lg-6">
      <div class="mb-2">
         <label class="form-label">Order by</label>
         <select class="form-select refine_filter" data-type="orderby" id="orderby">
            <option data-type="orderby" value="">--select--</option>
            <option data-type="orderby" value="ASC">Ascending</option>
            <option data-type="orderby" value="DESC">Descending</option>
         </select>
      </div>
   </div>

   <div class="col-lg-6">
      <div class="mb-2">
         <label class="form-label">Items per page</label>
         <select class="form-select refine_filter" data-type="perpage" id="perpage">
            <option data-type="perpage" value="10">10</option>
            <option data-type="perpage" value="25">25</option>
            <option data-type="perpage" value="50">50</option>
            <option data-type="perpage" value="100">100</option>
         </select>
      </div>
   </div>
</div>
<div class="float-end mb-2">
   <button type="submit" class="btn btn-primary btn-sm filter">Apply</button>
</div>