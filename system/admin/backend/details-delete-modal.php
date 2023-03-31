<!-- animation modal Dialogs start -->
<div class="md-modal md-effect-5" id="trash-1<?php echo $data['product_code'] ?>">
    <div class="md-content">
        <h3>Warning</h3>
        <div>
            <ul>
                <li>
                  <b>Read:</b> Are you sure you want to trash this Villa Style?
                </li>
            </ul>
            <button type="button" class="float-left btn btn-danger waves-effect md-close">Close</button>
            <a href="backend/details-delete-process.php?id=<?php echo $data['product_code'] ?>" class="float-right btn btn-success">Trash</a>
            <br>
        </div>
    </div>
</div>