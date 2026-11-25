<?= view('template/cabecera') ?>

<div class="container mt-4 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 style="color: #f1682d; font-weight: 700;">✍️ Redactar Publicación</h3>
                <a href="<?= base_url('newspaper') ?>" class="btn btn-outline-secondary btn-sm rounded-pill">Cancelar</a>
            </div>


            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <form action="<?= base_url('newspaper/guardar') ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        
                        <div class="form-group">
                            <label class="font-weight-bold text-muted small">Título del Artículo</label>
                            <input type="text" class="form-control form-control-lg" name="title" value="<?= old('title') ?>" placeholder="Ej: Importancia de la hidratación..." required>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold text-muted small">Categoría / Sección</label>
                            <select class="form-control" name="category" required>
                                <option value="" disabled <?= empty(old('category')) ? 'selected' : '' ?>>Seleccione dónde publicar...</option>
                                <option value="general" <?= old('category') == 'general' ? 'selected' : '' ?>>🌐 General (Información y Noticias)</option>
                                <option value="eventos" <?= old('category') == 'eventos' ? 'selected' : '' ?>>📅 Eventos y Jornadas Médicas</option>
                                <option value="recetas" <?= old('category') == 'recetas' ? 'selected' : '' ?>>🍲 Recetas Especiales Recomendadas</option>
                                <?php if(session()->get('rol') === 'admin'): ?>
                                    <option value="novedades" <?= old('category') == 'novedades' ? 'selected' : '' ?>>🎁 Promociones y Ofertas NutriCheckPro (Novedades)</option>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold text-muted small">Contenido de la Publicación</label>
                            <textarea class="form-control" name="contents" rows="8" placeholder="Escribe tu artículo o recomendación aquí..." required><?= old('contents') ?></textarea>
                        </div>

                        <div class="form-group">
                            <label class="font-weight-bold text-muted small">Imagen de Portada (Opcional)</label>
                            <input type="file" class="form-control-file border p-2 rounded bg-light" name="foto_post" accept="image/png, image/jpeg, image/jpg">
                            <small class="text-muted mt-1 d-block">Una imagen atractiva atraerá a más lectores (Formatos: JPG/PNG, Máximo 2MB).</small>
                        </div>

                        <button type="submit" class="btn btn-block text-white font-weight-bold shadow-sm rounded-pill mt-4" style="background-color: #28a745; padding: 14px; font-size: 1.1rem;">
                            🚀 Publicar Artículo
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= view('template/piepagina') ?>