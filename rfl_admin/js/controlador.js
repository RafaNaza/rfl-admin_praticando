var mods = new Array();

$(document).ready(function(){
	// Conteiner dos Modulos abertos
	// Add arrastar caixa
	ativarContainerFuncoes();	
	
	// Abre mavegação do menu
	$('#botao_menu').bind('click',function(){
		nclass=$(this).data('nclass');
		vclass=$(this).data('vclass');		
		$('#sidebarMenu').switchClass(vclass,nclass,500);
		$(this).data('nclass',vclass);
		$(this).data('vclass',nclass);
		
		if(nclass=="show"){
			$(this).fadeOut();
		}else{
			$(this).fadeIn();
		}
	});
	
	$( document ).on( "mousemove", function( event ) {
		scope =  $( window ).height() - $( 'footer' ).height() ;
		if(event.pageX <= 15 && event.pageY < scope ){
			$('#sidebarMenu').switchClass('hide','show',500);
		}
	});
	
	// Monitora click na janela para fechar o menu autmáticamente
	$(window).bind('click',function(event){
		if(!$(event.target).hasClass( "menu" ) && !$(event.target).hasClass( "botao_menu" )){
			escondeMenu();
		}
	});	
	
	// Ação no click do item do menu
	$('.item_menu').bind('click',function(){
		
		if($('#'+$(this).data('id')).attr('id')){
			//$('#'+$(this).data('id')).css("background", "blue");
			//$('header p').html('M&oacute;dulo j&aacute; est&aacute; aberto!');			
			$('article').removeClass('zIndexFront');
			$('article').addClass('zIndexBack');
			$('#'+$(this).data('id')).fadeIn().switchClass('zIndexBack','zIndexFront',200);
			$('.barra_icone').removeClass('active');
			$('#barra_icone_'+$(this).data('id')).addClass('active');
			escondeMenu();		
		}else{
			href = $(this).attr('href');
			//ajaxSimples(href,'workspace',$(this).data('id'));
			ajaxTemplate(href,'workspace');
			addIconeBarraTarefas($(this).data('iniciais'),$(this).data('id'));
			
			addMods($(this).data('id'));
			
			escondeMenu();
			setTimeout(function(){
				ativarContainerFuncoes();
			},300);
		}
		return false;
	});
	
	/* side bar content */
	_footerH = $("footer").height();
	_footerPT = eval($("footer").css('padding-top').replace("px",""));
	_footerPB = eval($("footer").css('padding-bottom').replace("px",""));
	_adjust = eval($("#sidebarMenu span a").css('padding-bottom').replace("px",""));	
	var _footerTotal = _footerH+_footerPT+_footerPB+_adjust;	
	$("#sidebarMenu span").height( $(window).height()-_footerTotal );
	$(window).resize(function(){
		$("#sidebarMenu span").height( $(this).height()-_footerTotal );
	});
});

// Funcoes -------------------------------------------
function addMods(id){
	if(mods['atual']){
		mods['anterior'] = mods['atual'];		
	}	
	mods['atual'] = id;
}

function ativarContainerFuncoes(){
	$( ".draggable").draggable();
	$( ".draggable .conteudo").draggable({ containment: "parent" });
	
	$(".draggable").bind('click',function(){
		$(".draggable").removeClass('zIndex');
		$(this).addClass('zIndex');
	});
	
	// função de fechar container do módulo
	$('.ext').bind('click', function(){
		$('#'+$(this).data('paiid')).remove();
		$('#barra_icone_'+$(this).data('paiid')).remove();
	});
	// minimizar container do módulo
	$('.min').bind('click', function(){
		elem = $('#'+$(this).data('paiid'));
		elem.data('lastTop',elem.position().top);
		//elem.animate({'top':'90%'}).fadeOut();
		
		$('#barra_icone_'+$(this).data('paiid')).removeClass('active');
		elem.fadeOut();
	});
	//abrir container do módulo se ele estiver minimizado
	$('.barra_icone').bind('click', function(){	
		if($('#'+$(this).data('paiid')).data('lastTop')>$(window).height()){
			$('#'+$(this).data('paiid')).data('lastTop','35');
		}
		//$('#'+$(this).data('paiid')).fadeIn().animate({'top':$('article').data('lastTop')}).addClass('zIndexFront');
		$('article').removeClass('zIndexFront');
		$('article').addClass('zIndexBack');
		$('#'+$(this).data('paiid')).fadeIn().switchClass('zIndexBack','zIndexFront',200);
		$('.barra_icone').removeClass('active');
		$('#barra_icone_'+$(this).data('paiid')).addClass('active');
	});
	
	$(".erro").bind("click",function(){
		$(this).fadeOut(400);
	});
	
	//Formulario Envios
	$(".formAjx").ajaxForm({
		dataType:  "json",
		beforeSubmit : function(){
			setMensagem("Aguarde...");
			$(".ajx").removeClass("q_form_erro");
			$(".ajx").attr('title','');	
			
			$(".s_form_ajax").each(function(){
				if(this){
					_label = $(this).children('label');				
					for(i=0; i<_label.length; i++){
						elem = $(_label[i]).children('.ajx');
						name  = elem.attr('name');
						value = elem.val();						
						er = /[\[,\]]/g;
						if(er.test(name)){				
							id = name.substring(name.indexOf("[")+1,name.indexOf("]"));		
						}else{						
							id = name.replace(er,"_");		
						}					
						elem.addClass('ajx_'+id);
					}
				}
			});	
		},
		success : function(out){
			
			if(out['refresh']){
				location.reload();
			}
		
			if(out['status']==0){
				if(out['erros']){
					$.map(out['erros'], function(value, index){
						obj = $(".ajx_"+index);
						obj.addClass("q_form_erro");
						obj.attr("title",value);
						
						obj.bind('focus',function(){
							$(this).removeClass("q_form_erro");$(this).attr("title",'');
						});
						obj.bind('click',function(){
							$(this).removeClass("q_form_erro");$(this).attr("title",'');
						});
					});
				}
				//setMensagem(out['msg']);
				//btFinalizaCompra();
			}			
			if(out['status']==1){			
				//setMensagem(out['msg']);
			}
			
		}
	});
}
function addIconeBarraTarefas(iniciais,id){
	$('.barra_icone').removeClass('active');
	$('.barra_de_tarefas').append('<span class="barra_icone active" data-paiid="'+id+'" id="barra_icone_'+id+'">'+iniciais+'</span>');
}
function escondeMenu(){
	$('#sidebarMenu').switchClass('show','hide',500);
	$('#botao_menu').data('nclass','show');
	$('#botao_menu').data('vclass','hide');
	
	//$("#botao_menu").fadeIn();
}
//ajax simples Recebe um url e devolve um conteúdo colocando onde preferir
function ajaxSimples(url,elemento_id,id){
	$.ajax({
		url : "php/core.php/?funcao=ajaxSimples&args[url]="+url+"&args[id]="+id,
		success:function(out){
			$('#'+elemento_id).append(out);
		}
	});
}

//ajax simples Recebe um url e devolve um conteúdo colocando onde preferir
function ajaxTemplate(url,elemento_id){
	$.ajax({
		url : "php/core.php/?funcao=template&args="+url,
		success:function(out){
			$('#'+elemento_id).append(out);
		}
	});
}