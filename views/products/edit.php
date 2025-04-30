<!-- MODAL PARA EDITAR PRODUCTO -->
<div class="modal fade" id="Editar<?= $product['product_id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel"
  aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Editar producto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="<?= PATH ?>/products/edit/<?= $product['product_id'] ?>"
          enctype="multipart/form-data">
          <div data-mdb-input-init class="form-outline mb-4">
            <input id="name" name="name" class="form-control" value="<?= $product['product'] ?>" />
            <label class="form-label" for="name">Nombre del producto</label>
          </div>
          <div data-mdb-input-init class="form-outline mb-4">
            <input id="description" name="description" class="form-control" value="<?= $product['description'] ?>" />
            <label class="form-label" for="description">Descripción del producto</label>
          </div>
          <div data-mdb-input-init class="form-outline mb-4">
            <input hidden value="<?= $product['image_url'] ?>" readonly name="oldImage" />
            <input type="file" id="image" name="image" class="form-control" accept="image/*" />
            <label class="form-label" for="image">Imagen del producto</label>
          </div>
          <div class="mb-3">
            <label for="category" class="form-label">Categoría</label>
            <select name="category" id="category" class="form-control">
              <option value="Cotton">Cotton</option>
              <option value="Linen">Linen</option>
              <option value="Silk">Silk</option>
              <option value="Synthetic">Synthetic</option>
              <option value="Wool">Wool</option>
            </select>
          </div>
          <div data-mdb-input-init class="form-outline mb-4">
            <input id="stock" name="stock" class="form-control" value="<?= $product['stock'] ?>" />
            <label class="form-label" for="stock">Número de existencias del producto</label>
          </div>
          <div data-mdb-input-init class="form-outline mb-4">
            <input id="price" name="price" class="form-control" value="<?= $product['price'] ?>" />
            <label class="form-label" for="price">Precio del producto</label>
          </div>

          <button type="submit" class="btn btn-primary">Guardar cambios</button>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>

      </div>
    </div>
  </div>
</div>
<!-- FIN MODAL PARA EDITAR PRODUCTO -->