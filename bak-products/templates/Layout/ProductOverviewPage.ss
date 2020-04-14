<section class="content-holder big-content-holder">
  <div class="container">
    <div class="col w-12">
      <h1 data-title-orig="$Title">$Title</h1>
      <% include LeadBlock %>

      <div id="description">
        <% loop $userFriendlyDataObject("Blocks") %>
          <div class="blocks clearfix" id="$PrintURLSegment">
            <% if $Title %><h2>$Title</h2><% end_if %>
              $HTML
          </div>
        <% end_loop %>
      </div>

      <div class="product-filter-holder clearfix">
        <a data-show-filter="categories" href="<% if $Locale = "de_DE"%>produkte/kategorie<% else_if $Locale == "es_ES" %>productos/categoría<% else %>products/category<% end_if %>" data-filter-name="<%t ProductOverviewPage.KATEGORIE "Kategorie" %>" class="head active"><%t ProductOverviewPage.KATEGORIE "Kategorie" %></a>
        <a data-show-filter="usages" href="<% if $Locale = "de_DE"%>produkte/anwendung<% else_if $Locale == "es_ES" %>productos/uso<% else %>products/application<% end_if %>" data-filter-name="<%t ProductOverviewPage.ANWENDUNG "Anwendung" %>" class="head"><%t ProductOverviewPage.ANWENDUNG "Anwendung" %></a>
        <span class="head search"><input data-search-products placeholder="<%t ProductOverviewPage.Name 'Name' %>" /></span>
      </div>

      <div data-product-list class="product-list" data-no-products-found="<%t ProductOverviewPage.NOPRODUCTS "Keine Produkte gefunden" %>">
        <a href="javascript: history.back()" class="close-products"></a>
        <div class="holder"></div>
      </div>

      <div data-filter-list="categories" class="filter-list clearfix active">

          <% loop $getCategories %>
          <a href="$Link($Top.Locale)" class="col w-4" data-filter-name="$T(Title)">
            <div class="box clearfix">
              <% if $T(Title) %><h3>$T(Title)</h3><% end_if %>
              <% if $ProductCategoryImage %>
                <img src="$ProductCategoryImage.CroppedFocusedImage(350,250).URL" alt="$T(Title)"/>
              <% end_if %>
              <div class="link-more">$T(Title) <span class="icon ion-ios-arrow-right"></span></div>
            </div>
          </a>
          <% end_loop %>

      </div>

      <div data-filter-list="usages" class="filter-list clearfix">
          <% loop $getUseArea %>
            <div class="blocks clearfix">
              <% if $T(Title) %>
                <div class="col w-12">
                  <h2>$T(Title)</h2>
                </div>
              <% end_if %>
              <% if $Usages %>
                <% loop $Usages %>
               
                <a href="$Link($Top.Top.Locale)" class="col w-4" data-filter-name="$UseArea.T(Title)">
                  <div class="box clearfix">
                    <% if $Image %>
                        <img src="$Image.CroppedFocusedImage(350,250).URL" alt="$Title"/>
                    <% end_if %>
                        $T(Description)
                        <div class="link-more"><%t ProductOverviewPage.PRODUKTE "Passende Produkte" %><% include DefaultIcon %></div>
                    </div>
                </a>
                <% end_loop %>
              <% end_if %>
            </div>
          <% end_loop %>
      </div>
    </div>
  </div>
</section>



















