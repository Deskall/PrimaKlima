<%-- <div class="chosen-container chosen-container-single chosen-container-single-nosearch" title="" id="Form_ItemEditForm_Effect_chosen" style="width: 100%;"><a class="chosen-single">
  <span><i class="font-icon-block-banner"></i> Bild grossieren
	</span>
  <div><b></b></div>
</a>
<div class="chosen-drop">
  <div class="chosen-search">
    <input class="chosen-search-input" type="text" autocomplete="off" readonly="">
  </div>
  <ul class="chosen-results"><li class="active-result" data-option-array-index="0" style="">kein
	</li><li class="active-result" data-option-array-index="1" style="">Zweiten Bild anzeigen
	</li><li class="active-result result-selected" data-option-array-index="2" style="">Bild grossieren
	</li><li class="active-result" data-option-array-index="3" style="">CallToAction anzeigen
	</li></ul>
</div></div> --%>

<%-- <div class="html-dropdown chosen-container chosen-container-single chosen-container-single-nosearch">
    <a class="chosen-single"><i class="font-icon-block-banner"></i><div><b></b></div></a>  
  <div class="chosen-drop">
   <% loop $Options %>
    <div value="$Value.XML" class="html-dropdown-option <% if $Selected %>selected"<% end_if %> <% if $Disabled %>disabled<% end_if %>">
      <i class="font-icon-block-banner"></i>
      <% if Icon %><i class="$Icon"></i><% end_if %>
      <% if $Title.exists %>$Title.XML<% else %>&nbsp;<% end_if %>
    </div>
  <% end_loop %>
  </div>
</div> --%>

<select $AttributesHTML>
<% loop $Options %>
  <option value="$Value.XML"<% if $Selected %> selected="selected"<% end_if %><% if $Disabled %> disabled="disabled"<% end_if %><% loop $Attributes %>$Name="$Value"<% end_loop %>>$Title.XML</option>
<% end_loop %>
</select>