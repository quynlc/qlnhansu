<!-- BEGIN: main -->
<!-- BEGIN: view -->
<form class="form-inline" action="{NV_BASE_ADMINURL}index.php" method="get">
	<input type="hidden" name="{NV_LANG_VARIABLE}"  value="{NV_LANG_DATA}" />
	<input type="hidden" name="{NV_NAME_VARIABLE}"  value="{MODULE_NAME}" />
	<input type="hidden" name="{NV_OP_VARIABLE}"  value="{OP}" />
	<strong>{LANG.search_title}</strong>&nbsp;<input class="form-control" type="text" value="{Q}" name="q" maxlength="255" />&nbsp;
	<input class="btn btn-primary" type="submit" value="{LANG.search_submit}" />
</form>
<br>

<form class="form-inline" action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th>{LANG.Weight}</th>
					<th>{LANG.Tenlop}</th>
					<th>{LANG.Gvcn}</th>
					<th>&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				<!-- BEGIN: loop -->
				<tr>
					<td>
						<select class="form-control" id="id_weight_{VIEW.Id}" onchange="nv_change_weight('{VIEW.Id}');">
						<!-- BEGIN: Weight_loop -->
							<option value="{WEIGHT.key}"{WEIGHT.selected}>{WEIGHT.title}</option>
						<!-- END: Weight_loop -->
					</select>
				</td>
					<td> {VIEW.Tenlop} </td>
					<td> {VIEW.Gvcn} </td>
					<td class="text-center"><i class="fa fa-edit fa-lg">&nbsp;</i> <a href="{VIEW.link_edit}">{LANG.edit}</a> - <em class="fa fa-trash-o fa-lg">&nbsp;</em> <a href="{VIEW.link_delete}" onclick="return confirm(nv_is_del_confirm[0]);">{LANG.delete}</a></td>
				</tr>
				<!-- END: loop -->
			</tbody>
		</table>
	</div>
</form>
<!-- END: view -->

<!-- BEGIN: error -->
<div class="alert alert-warning">{ERROR}</div>
<!-- END: error -->
<form class="form-inline" action="{NV_BASE_ADMINURL}index.php?{NV_LANG_VARIABLE}={NV_LANG_DATA}&amp;{NV_NAME_VARIABLE}={MODULE_NAME}&amp;{NV_OP_VARIABLE}={OP}" method="post">
	<input type="hidden" name="Id" value="{ROW.Id}" />
	<div class="table-responsive">
		<table class="table table-striped table-bordered table-hover">
			<tbody>
				<tr>
					<td> {LANG.Tenlop} </td>
					<td><input class="form-control" type="text" name="Tenlop" value="{ROW.Tenlop}" required="required" oninvalid="setCustomValidity( nv_required )" oninput="setCustomValidity('')" /></td>
				</tr>
				<tr>
					<td> {LANG.Alias} </td>
					<td><input class="form-control" type="text" name="Alias" value="{ROW.Alias}" id="id_Alias" />&nbsp;<i class="fa fa-refresh fa-lg icon-pointer" onclick="nv_get_alias('id_Alias');">&nbsp;</i></td>
				</tr>
				<tr>
					<td> {LANG.Gvcn} </td>
					<td><input class="form-control" type="text" name="Gvcn" value="{ROW.Gvcn}" /></td>
				</tr>
			</tbody>
		</table>
	</div>
	<div style="text-align: center"><input class="btn btn-primary" name="submit" type="submit" value="{LANG.save}" /></div>
</form>

<script type="text/javascript">
//<![CDATA[
	function nv_get_alias(id) {
		var title = strip_tags( $("[name='Tenlop']").val() );
		if (title != '') {
			$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=lophoc&nocache=' + new Date().getTime(), 'get_alias_title=' + encodeURIComponent(title), function(res) {
				$("#"+id).val( strip_tags( res ) );
			});
		}
		return false;
	}
	function nv_change_weight(id) {
		var nv_timer = nv_settimeout_disable('id_weight_' + id, 5000);
		var new_vid = $('#id_weight_' + id).val();
		$.post(script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=lophoc&nocache=' + new Date().getTime(), 'ajax_action=1&Id=' + id + '&new_vid=' + new_vid, function(res) {
			var r_split = res.split('_');
			if (r_split[0] != 'OK') {
				alert(nv_is_change_act_confirm[2]);
			}
			clearTimeout(nv_timer);
			window.location.href = script_name + '?' + nv_name_variable + '=' + nv_module_name + '&' + nv_fc_variable + '=lophoc';
			return;
		});
		return;
	}


//]]>
</script>

<!-- BEGIN: auto_get_alias -->
<script type="text/javascript">
//<![CDATA[
	$("[name='Tenlop']").change(function() {
		nv_get_alias('id_Alias');
	});
//]]>
</script>
<!-- END: auto_get_alias -->
<!-- END: main -->