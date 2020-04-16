<section class="content-holder big-content-holder">
  <div class="container">
    <div class="col w-12">
      <h1 data-title-orig="$Title">$Title<% if $SelectedUsage.UseArea.T(Title) %>: $SelectedUsage.UseArea.T(Title)<% end_if %></h1>
      <% include LeadBlock %>

      <div class="product-filter-holder clearfix">
        <a data-show-filter="categories" href="<% if $Locale = "de_DE"%>produkte/kategorie<% else_if $Locale == "es_ES" %>productos/categoria<% else %>products/category<% end_if %>" data-filter-name="<%t ProductOverviewPage.KATEGORIE "Kategorie" %>" class="head"><%t ProductOverviewPage.KATEGORIE "Kategorie" %></a>
        <a data-show-filter="usages" href="<% if $Locale = "de_DE"%>produkte/anwendung<% else_if $Locale == "es_ES" %>productos/uso<% else %>products/application<% end_if %>" data-filter-name="<%t ProductOverviewPage.ANWENDUNG "Anwendung" %>" class="head active "><% if $showProducts %>$SelectedUsage.T(Title)<% else %><%t ProductOverviewPage.ANWENDUNG "Anwendung" %><% end_if %></a>
        <span class="head search"><input data-search-products placeholder="Name" /></span>
      </div>

      <div data-product-list class="product-list <% if $showProducts %>active<% end_if %>" data-no-products-found="<%t ProductOverviewPage.NOPRODUCTS "Keine Produkte gefunden" %>">
        <a href="javascript: history.back()" class="close-products"></a>
        <div class="holder">      
          <% loop $SelectedUsage.Products %>
            <div class="product">
              <div class="col w-4">
              <% if $MainImage %>
                <a href="$Link($Top.Locale)">$MainImage.PaddedImage(210,150,FFFFFF)</a>
              <% end_if %>
              </div>
              <div class="col w-8">
                <h3>$T(Name)</h3>
                <p class="lead-product">$T(Lead)</p>
                <p class="description">$T(Description)</p>
                <% if $MainImage %><% else %>
                <p class="description">$T(Features)</p>
                <% end_if %>
              </div>
              <div class="link-more">
                <a href="$Link($Top.Locale)"><%t Main.ZUMPRODUKT "Zum Produkt"%>  <span class="icon ion-ios-arrow-right"></span></a>
              </div>
            </div>
          <% end_loop %>
        </div>
      </div>
      <div data-filter-list="categories" class="filter-list clearfix">
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

      <div data-filter-list="usages" class="filter-list clearfix <% if $showUsages %>active<% end_if %>">
          <% loop $getUseArea %>
            <div class="blocks clearfix">
              <div class="col w-12">
               <% if $T(Title) %><h2>$T(Title)</h2><% end_if %>
              </div>
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



















