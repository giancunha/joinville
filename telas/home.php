<div class="contentpanel">
    <div class="col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h4 class="panel-title">Notificações</h4>
                <p>Após o desenvolvimento completo do sistema será incluído a Dashboard, onde as ações principais do sistema serão exibidas, assim como dados.</p>
                <p>A pesquisa na barra acima só irá funcionar após todas as ferramentas estiverem completamentes desenvolvidas.</p>
            </div><!-- panel-heading -->
        </div><!-- panel -->
    </div>

    <div class="col-sm-3">
        <div class="panel panel-warning panel-alt widget-today">
            <div class="panel-heading text-center">
                <i class="fa fa-calendar-o"></i>
            </div>
            <div class="panel-body text-center">
                <h3 class="today"><?php echo diaSemana(date('D')) ?>, <?php echo date('d/m/Y') ?></h3>
            </div><!-- panel-body -->
        </div>
    </div>

    <div class="col-sm-3">
        <div class="panel panel-danger panel-alt widget-time">
            <div class="panel-heading text-center">
                <i class="glyphicon glyphicon-time"></i>
            </div>
            <div class="panel-body text-center">
                <h3 class="today"><?php echo date('H:i') ?></h3>
            </div><!-- panel-body -->
        </div>
    </div>
</div>
