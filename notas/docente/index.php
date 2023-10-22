<?php
include_once("../../login/check.php");
include_once("../../class/config.php");
include_once("../../class/curso.php");
include_once("../../class/docente.php");
include_once("../../class/docentemateriacurso.php");
include_once("../../class/materias.php");
include_once("../../class/casilleros.php");
$titulo="NRegistroNotas";
$folder="../../";
$docente=new docente;
$curso=new curso;
$docmateriacurso=new docentemateriacurso;
$materias=new materias;
$config=new config;
$casilleros=new casilleros;
$CodDocente=$_SESSION['CodUsuarioLog'];
$_SESSION['CodDocente']=$CodDocente;
$c=$_GET['c'];
if($c!=""){
	$cas=$casilleros->mostrar($c);
	$cas=array_shift($cas);
	$dmc=$docmateriacurso->mostrarCodDocenteMateriaCurso($cas['CodDocenteMateriaCurso']);
	$dmc=array_shift($dmc);
}

$TotalPeriodo=$config->mostrarConfig("TotalPeriodo",1);
$trimestreActual=$config->mostrarConfig("TrimestreActual",1);
?>
<?php include_once($folder."cabecerahtml.php");?>
<script language="javascript" type="text/javascript" src="../../js/core/plugins/jquery.alphanumeric.pack.js"></script>
<script language="javascript" type="text/javascript" src="../../js/notas/docente.js"></script>
<script language="javascript">
var NotasGuardadoCorrectamente="<?php echo $idioma['NotasGuardadoCorrectamente']?>";
var NombresGuardadoCorrectamente="<?php echo $idioma['NombresGuardadoCorrectamente']?>";
var NotaExcedidaLimite="<?php echo $idioma['NotaExcedidaLimite']?>";
var NotaExcedidaMinimo="<?php echo $idioma['NotaExcedidaMinimo']?>";
</script>
<?php include_once($folder."cabecera.php");?>
<div class="span12 box">
<div class="box-header"><h2><i class="icon-cog"></i><span class="break"></span><?php echo $idioma['Configuracion']?></h2></div>
<div class="box-content">
    <div class="row-fluid">
        <div class="span3">
            <div class="box-header"><?php echo $idioma['Curso']?></div>    
            <div class="box-content">
                <?php campo("tcurso","search","","span12",0,$idioma['BusquePor'])?>
                <select class="span12" name="Curso">
                <?php foreach($docmateriacurso->mostrarDocenteOrdenCurso($CodDocente) as $cur){
                        $c=$curso->mostrarCurso($cur['CodCurso']);
                        $c=$c=array_shift($c);
                        ?>
                        <option  value="<?php echo $c['CodCurso'];?>" <?php echo $c['CodCurso']==$dmc['CodCurso']?'selected="selected"':''?>><?php echo $c['Nombre'];?></option>
                <?php }?>
                </select>
            </div>
        </div>
        <div class="span3">
            <div class="box-header"><?php echo $idioma['Materia']?></div>    
            <div class="box-content">
                <?php campo("tmateria","search","","span12",0,$idioma['BusquePor'])?>
                <select name="Materia" class="span12">
                <?php foreach($docmateriacurso->mostrarDocenteMateria($CodDocente) as $docMat){
                        $m=$materias->mostrarMateria($docMat['CodMateria']);
                        $m=array_shift($m);
                        ?>
                        <option value="<?php echo $m['CodMateria'];?>" <?php echo $c['CodMateria']==$dmc['CodMateria']?'selected="selected"':''?>><?php echo $m['Nombre'];?></option>
                <?php }?>
                </select>
            </div>
        </div>
        <div class="span2">
            <div class="box-header"><?php echo $idioma['Periodo']?></div>    
            <div class="box-content">
                <?php campo("tperiodo","search","","span12",0,$idioma['BusquePor'])?>
                <select name="Periodo" class="span12">
                <?php
                for($i=1;$i<=$TotalPeriodo;$i++){?>
                    <option value="<?php echo $i;?>" <?php echo $i==$cas['Trimestre']?'selected="selected"':''?>><?php echo $i;?></option>
                <?php }?>
                </select>
            </div>
        </div>
        <div class="span4">
        	<div class="box-header"><h2><?php echo $idioma['Acciones']?></h2></div>
            <div class="box-content">
            	<input type="button" class="btn btn-success" value="<?php echo $idioma['RegistroNotas']?>" id="registronotas"/><br /><br />
                <input type="button" class="btn btn-info" value="<?php echo $idioma['RegistroImprimir']?>" id="registroimprimir"/><br /><br />
                <input type="button" class="btn btn-inverse" value="<?php echo $idioma['CambiarNombreCasillas']?>" id="cambiarnombres"/><br /><br />
                <input type="button" class="btn btn-warning" value="<?php echo $idioma['NotasCualitativas']?>" id="notascualitativa"/>
            </div>
        </div>
	</div>
</div>
</div>
</div><?php // fin row?>
<div class="row-fluid">
<div class="span12">
    <div class="box-header"><?php echo $idioma['Alumnos']?></div>
    <div class="box-content" id="alumnos">
        
    </div>
</div>

<?php
	$cnf=($config->mostrarConfig("CodigoSeguimientoNotasDocente"));
	echo $cnf['Valor'];
?>
<?php include_once($folder."pie.php");?>