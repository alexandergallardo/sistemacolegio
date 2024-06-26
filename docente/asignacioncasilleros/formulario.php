<?php
include_once("../../login/check.php");
if (!empty($_POST['CodDocente'])) {
    include_once("../../class/materias.php");
    include_once("../../class/curso.php");
    include_once("../../class/docentemateriacurso.php");
    include_once("../../class/config.php");
    $CodDocente = $_POST['CodDocente'];
    $config = new config;
    $cnf = ($config->mostrarConfig("PeriodoActual"));
    $PeriodoActual = $cnf['Valor'];
    $materias = new materias;
    $curso = new curso;
    $docentemateriacurso = new docentemateriacurso;
    $docmateriaCurso = $docentemateriacurso->mostrarTodoDocente($CodDocente);
?>
    <div class="alert alert-info"><?php echo $idioma['AsignacionDocenteErronea'] ?></div>
    <table class="table table-bordered table-striped table-hover table-condensed">
        <thead>
            <tr>
                <th></th>
                <th><span title="<?php echo $idioma['Curso'] ?>"><?php echo ($idioma['Curso']) ?></span></th>
                <th><?php sacarToolTip($idioma['Materia'], "", "R") ?></th>
                <th><?php echo $idioma['Dps'] ?></th>
                <th><?php echo sacarToolTip($idioma['Sexo']) ?></th>
                <th><?php sacarToolTip($idioma['MaximaNota']) ?></th>
                <th><?php sacarToolTip($idioma['NotaAprobacion']) ?></th>
            </tr>
        </thead>
        <?php
        foreach ($docmateriaCurso as $dmc) {
            $cur = $curso->mostrarCurso($dmc['CodCurso']);
            $cur = array_shift($cur);
            $ma = ($materias->mostrarMateria($dmc['CodMateria']));
            $ma = array_shift($ma);
            $SA = $dmc['SexoAlumno'] == 2 ? $idioma['AmbosSexos'] : ($dmc['SexoAlumno'] == 1 ? $idioma['Hombres'] : $idioma['Mujeres']);
        ?>
            <tr>
                <td>
                    <input type="radio" name="CodDocenteMateriaCurso" value="<?php echo $dmc['CodDocenteMateriaCurso'] ?>" id="c<?php echo $dmc['CodDocenteMateriaCurso'] ?>" data-bimestre="<?php echo $cur['Bimestre']; ?>" required>
                </td>
                <td><label for="c<?php echo $dmc['CodDocenteMateriaCurso'] ?>"><?php echo $cur['Abreviado'] ?></label></td>
                <td><label for="c<?php echo $dmc['CodDocenteMateriaCurso'] ?>"><?php sacarToolTip($ma['Nombre'], $ma['Abreviado'], 0) ?></label></td>
                <td><label for="c<?php echo $dmc['CodDocenteMateriaCurso'] ?>"><?php echo $cur['Dps'] ? $idioma['Si'] : $idioma['No'] ?></label></td>
                <td><label for="c<?php echo $dmc['CodDocenteMateriaCurso'] ?>"><?php sacarToolTip($SA) ?></label></td>
                <td class="der"><label for="c<?php echo $dmc['CodDocenteMateriaCurso'] ?>"><?php echo $cur['NotaTope'] ?></label></td>
                <td class="der"><label for="c<?php echo $dmc['CodDocenteMateriaCurso'] ?>"><?php echo $cur['NotaAprobacion'] ?></label></td>
            </tr>
        <?php
        }
        ?>
    </table>
    <table class="table table-bordered table-hover">

        <tr>
            <td><?php echo $idioma['PeriodoActual'] ?>:<br />
                <select name="Periodo" class="span12">
                    <?php for ($i = 1; $i <= 4; $i++) { ?>
                        <option value="<?php echo $i; ?>" <?php echo ($i == $PeriodoActual) ? 'selected="selected"' : ''; ?>>
                            <?php echo $i; ?>
                            <?php switch ($i) {
                                case 1: {
                                        echo $idioma["Bimestre"] . " - " . $idioma["Trimestre"];
                                    }
                                    break;
                                case 2: {
                                        echo $idioma["Bimestre"] . " - " . $idioma["Trimestre"];
                                    }
                                    break;
                                case 3: {
                                        echo $idioma["Bimestre"] . " - " . $idioma["Trimestre"];
                                    }
                                    break;
                                case 4: {
                                        echo $idioma["Bimestre"];
                                    }
                                    break;
                            } ?>
                        </option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr id="FilaTipoNota" class="">
            <td><?php echo $idioma['TipoRegistroNotas'] ?>:<br />
                <select name="TipoNota" id="TipoNota" class="span12" readonly>
                    <option value=""><?php echo $idioma['Normal'] ?></option>
                    <option value="avanzado" selected><?php echo $idioma['Avanzado'] ?></option>
                    <option value="literal"><?php echo $idioma['Literal'] ?></option>
                </select>
                <div class="alert alert-error"><?php echo $idioma['NotaAvanzado'] ?></div>
            </td>
        </tr>
        <tr>
            <td><?php echo $idioma['NumeroCasillas'] ?>:<br />
                <select name="casillas" class="span12">
                    <?php for ($i = 3; $i <= 25; $i++) { ?>
                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td><?php echo $idioma['FormulaCalificacion'] ?>:<br />
                <textarea name="formula" class="nocap span12" rows="4" readonly></textarea>
                <a class="btn btn-mini pull-left" id="formula"><?php echo $idioma['PromedioPorDefecto'] ?></a>
                <a class="btn btn-mini pull-right" id="habilitarmodificarformula"><i class="icon-pencil"></i></a>
            </td>
        </tr>
    </table>
    <input type="submit" value="<?php echo $idioma['Guardar'] ?>" class="btn btn-success guardar">
<?php
}
?>
<script language="javascript" type="text/javascript">
    var GuardarConfiguracionCasilleros = "<?php echo $idioma['GuardarConfiguracionCasilleros'] ?>";
    var NoSePodraModificar = "<?php echo $idioma['NoSePodraModificar'] ?>";
    var DebeSeleccionarCursoMateria = "<?php echo $idioma['DebeSeleccionarCursoMateria'] ?>";
</script>