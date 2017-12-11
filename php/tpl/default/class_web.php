<?php include_once('common_header.php');?>
<!-- 产品分页 -->
<div class="list-nav"><a href="index" class="member-nav-L"></a><a href="user" class="member-nav-R2"></a></div>
<ul id="accordion" class="accordion">
	<li>
		<div class="link class-1">
			<span>遥控/电动玩具</span>
		</div>
		<ul class="submenu">
			<li><a href="#">需求文字</a></li>
			<li><a href="#">需求文字</a></li>
			<li><a href="#">需求文字</a></li>
			<li><a href="#">需求文字</a></li>
			<li><a href="#">需求文字</a></li>
			<li><a href="#">需求文字</a></li>
			<li><a href="#">需求文字</a></li>
			<li><a href="#">需求文字</a></li>
			<li><a href="#">需求文字</a></li>
			<li><a href="#">需求文字</a></li>
		</ul>
	</li>
	<li>
		<div class="link class-2">
			<span>早教/音乐玩具</span>
		</div>
		<ul class="submenu">
			<li><a href="#">需求文字</a></li>
			<li><a href="#">需求文字</a></li>
			<li><a href="#">需求文字</a></li>
			<li><a href="#">需求文字</a></li>
			<li><a href="#">需求文字</a></li>
			<li><a href="#">需求文字</a></li>
			<li><a href="#">需求文字</a></li>
			<li><a href="#">需求文字</a></li>
			<li><a href="#">需求文字</a></li>
			<li><a href="#">需求文字</a></li>
		</ul>
	</li>
	<li>
		<div class="link class-3">
			<span>过家家玩具</span>
		</div>
		<ul class="submenu">
			<li><a href="#">需求文字</a></li>
			<li><a href="#">需求文字</a></li>
			<li><a href="#">需求文字</a></li>
			<li><a href="#">需求文字</a></li>
			<li><a href="#">需求文字</a></li>
			<li><a href="#">需求文字</a></li>
			<li><a href="#">需求文字</a></li>
			<li><a href="#">需求文字</a></li>
			<li><a href="#">需求文字</a></li>
			<li><a href="#">需求文字</a></li>
		</ul>
	</li>
	<li>
		<div class="link class-4">
			<span>童车玩具</span>
		</div>
		<ul class="submenu">
			<li><a href="#">需求文字</a></li>
			<li><a href="#">需求文字</a></li>
			<li><a href="#">需求文字</a></li>
			<li><a href="#">需求文字</a></li>
			<li><a href="#">需求文字</a></li>
			<li><a href="#">需求文字</a></li>
			<li><a href="#">需求文字</a></li>
			<li><a href="#">需求文字</a></li>
			<li><a href="#">需求文字</a></li>
			<li><a href="#">需求文字</a></li>
		</ul>
	</li>
	<li>
		<div class="link class-5"><span>益智玩具</span></div>
		<ul class="submenu">
			<li><a href="#">需求文字</a></li>
			<li><a href="#">需求文字</a></li>
			<li><a href="#">需求文字</a></li>
			<li><a href="#">需求文字</a></li>
			<li><a href="#">需求文字</a></li>
			<li><a href="#">需求文字</a></li>
			<li><a href="#">需求文字</a></li>
			<li><a href="#">需求文字</a></li>
			<li><a href="#">需求文字</a></li>
			<li><a href="#">需求文字</a></li>
		</ul>
	</li>
	<li>
		<div class="link class-6"><span>其它玩具</span></div>
		<ul class="submenu">
			<li><a href="#">需求文字</a></li>
			<li><a href="#">需求文字</a></li>
			<li><a href="#">需求文字</a></li>
			<li><a href="#">需求文字</a></li>
			<li><a href="#">需求文字</a></li>
			<li><a href="#">需求文字</a></li>
			<li><a href="#">需求文字</a></li>
			<li><a href="#">需求文字</a></li>
			<li><a href="#">需求文字</a></li>
			<li><a href="#">需求文字</a></li>
		</ul>
	</li>
</ul>

<script type="text/javascript">
$(function() {
	var Accordion = function(el, multiple) {
		this.el = el || {};
		this.multiple = multiple || false;

		// Variables privadas
		var links = this.el.find('.link');
		// Evento
		links.on('click', {el: this.el, multiple: this.multiple}, this.dropdown)
	}

	Accordion.prototype.dropdown = function(e) {
		var $el = e.data.el;
			$this = $(this),
			$next = $this.next();

		$next.slideToggle();
		$this.parent().toggleClass('open');

		if (!e.data.multiple) {
			$el.find('.submenu').not($next).slideUp().parent().removeClass('open');
		};
	}

	var accordion = new Accordion($('#accordion'), false);
});
</script>

<!-- 底部导航 -->
<?php include "footer_menu_web_tmp.php"; ?>
<?php include_once('common_footer.php');?>
