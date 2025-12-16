<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery.js"></script>
<script src="<?php echo $this->config->base_url(); ?>assets/js/jquery-ui-1.9.2.custom.min.js"></script>
<script>		
	$(document).ready(function(){	

    /* initialize the external events
     -----------------------------------------------------------------*/
    /* initialize the calendar
     -----------------------------------------------------------------
	 {title: 'Meeting',start: '2015-09-14T10:30:00',end: '2015-02-12T12:30:00'},
	 */

    $('#calendar').fullCalendar({
         events: [
				<?php echo $eventos; ?>
                ],
        header: {
            left: 'prev,next today',
            center: 'title',
        },
		monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
		buttonText: {
		prev:"Anterior",
		next:"Proximo",
		today:"Hoje",
		month:"Mês",
		week:"Semana",
		day:"Dia"},
        editable: true,
        droppable: true, // this allows things to be dropped onto the calendar
        drop: function () {
            // is the "remove after drop" checkbox checked?
            if ($('#drop-remove').is(':checked')) {
                // if so, remove the element from the "Draggable Events" list
                $(this).remove();
            }
        }
       
    });


});
 </script>

<div id="wrapper">
                <div class="content-wrapper container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-title">
                                <h1>Calend&aacute;rio<small></small></h1>
                                <ol class="breadcrumb">
                                    <li><a href="#"><i class="fa fa-home"></i></a></li>
                                    <li class="active">Calend&aacute;rio</li>
									<li> <a href="<?php echo $this->config->base_url();?>index.php/calendario/inserir"> <i class="fa fa-plus"></i> Inserir Novo Evento </a></li>
                                </ol>
                            </div>
                        </div>
                    </div><!-- end .page title-->


                    <div class="row">
                        <div class="col-md-12">
                            <div id='calendar'></div>

                            <div class="clearfix"></div>

                        </div>
                    </div>

                </div> 
            </div>