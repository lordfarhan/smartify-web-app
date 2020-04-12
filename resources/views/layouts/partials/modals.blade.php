<div id="modal-delete" class="modal fade text-danger" role="dialog">
    <div class="modal-dialog ">
      <!-- Modal content-->
      <form action="" id="deleteForm" route="" method="DELETE">
          <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Attention!</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                  {{ csrf_field() }}
                  {{ method_field('DELETE') }}
                  <p class="text-center">Are you sure want to delete?</p>
              </div>
              <div class="modal-footer">
                  <center>
                      <button type="button" class="btn btn-success" data-dismiss="modal">Cancel</button>
                      <button type="submit" name="" class="btn btn-danger" data-dismiss="modal" onclick="formSubmit()">Yes, Delete</button>
                  </center>
              </div>
          </div>
      </form>
    </div>
   </div>