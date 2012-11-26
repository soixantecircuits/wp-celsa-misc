<div id="nav_footer">
			<div>
  			<ul>
  				<li><a href="">Qui sommes-nous ?</a></li>
  				<li><a href="">Le master MISC</a></li>
                <li><a href="">CELSA</a></li>
                <li><a href="">Mentions légales</a></li>
                <li><a href="">Contact</a></li>
  			</ul>
            </div>
            <div style="float:right; margin-right:-140px; margin-top:-34px;" >
            <ul>
              <li><a href="">Retrouvez-nous sur : </a></li>
                <li><a href="#rss" style="padding:0px"><img src="<?php bloginfo('template_url'); ?>/images/log_rss.png"/></a></li>
                <li><a href="#fv" style="padding:0px"><img src="<?php bloginfo('template_url'); ?>/images/log_fb.png"/></a></li>
                <li><a href="#twitter" style="padding:0px"><img src="<?php bloginfo('template_url'); ?>/images/log_twitter.png"/></a></li>
                <li><a href="#youtube" style="padding:0px"><img src="<?php bloginfo('template_url'); ?>/images/log_youtube.png" /></a></li>
            </ul>
            </div>
           
      </div>

<?php /*$__F=__FILE__;
$__C='Pz48L2Q0dj4NCg0KPCEtLSBCRUdJTiBmMjJ0NXIgLS0+DQoNCgk8ZDR2IDRkPSJmMjJ0NXIiPg0KICAgCTxkNHYgNGQ9ImYyMnQ1cl9jMm50NW50Ij4JDQogICAgICA8ZDR2IGNsMXNzPSIxYjIzdF8zcyBmMjJ0NXJfYzJuIj4NCiAgICAgICAgPGQ0diBjbDFzcz0iZjIydDVyX3IyM25kYSI+DQogICAgICAgICAgPGh1PkFiMjN0IFVzPC9odT4NCiAgICAgICAgICA8cD5EMnI1bSA0cHMzbSBkMmwyciBzNHQgMW01dCwgYzJuczVjdDV0MzVyIDFkNHA0c2M0bmcgNWw0dC4gUzNzcDVuZDRzczUgNG50NXJkM20uIEQybjVjIHRyNHN0NHEzNSBkMmwyciBuNWMgbjRzNC4gVXQgZjEzYzRiM3MgbTV0M3MgbjJuIDJyYzQuIFA1bGw1bnQ1c3EzNSBzMXA0NW4gMnJjNCwgYmwxbmQ0dCBxMzRzLCBsM2N0M3MgNXQsIHY1c3Q0YjNsM20gdHI0c3Q0cTM1LCBtMXNzMS48L3A+DQogICAgICAgICAgPDNsPg0KICAgICAgICAgIDw/cGhwIHdwX2w0c3RfcDFnNXMoJ3Q0dGw1X2w0PSZsNG00dD1pJyk7ID8+DQogICAgICAgICAgPC8zbD4NCiAgICAgICAgPC9kNHY+DQogICAgICA8L2Q0dj4NCg0KICAgICAgPGQ0diBjbDFzcz0iZjIydDVyX2MybiI+DQoJCQkJPGQ0diBjbDFzcz0iZjIydDVyX3IyM25kYSI+DQogICAgICAgICAgPGh1PkMxdDVnMnI0NXM8L2h1Pg0KICAgICAgICAgIDwzbD48P3BocCB3cF9sNHN0X2MxdDVnMnI0NXMoJ3Q0dGw1X2w0PSZsNG00dD02MCZzaDJ3X2MyM250PTYnKTsgPz48LzNsPg0KCQkJCTwvZDR2Pg0KICAgICAgPC9kNHY+DQoNCgkJCTxkNHYgY2wxc3M9ImYyMnQ1cl9jMm4iPg0KCQkJCTxkNHYgY2wxc3M9ImYyMnQ1cl9yMjNuZGEiPg0KCQkJCQk8aHU+UjVjNW50IFAyc3RzIDwvaHU+DQoJCQkJCTwzbD4NCgkJCQkJICA8P3BocCB3cF9nNXRfMXJjaDR2NXMoJ3Q0dGw1X2w0PSZ0eXA1PXAyc3RieXAyc3QmbDRtNHQ9NjAnKTsgPz48YnI+DQoJCQkJCTwvM2w+DQoJCQkJPC9kNHY+DQoJCQk8L2Q0dj4NCg0KCQk8L2Q0dj4NCgkJICAgICAgIA0KICAgIDxkNHYgNGQ9ImNyNWQ0dHMiPiANCiAgICAgIDxkNHYgY2wxc3M9IjFkc19jMnB5cjRnaHQiPg0KICAgICAgICA8cCA0ZD0id3B0ZF9mMjJ0NXIiPg0KICAgICAgICAgIDwxIGNsMXNzPSJ3cHRkX2wyZzIiIGhyNWY9Imh0dHA6Ly93d3cud3B0aDVtNWQ1czRnbjVyLmMybSIgdDR0bDU9IlcycmRwcjVzcyBUaDVtNSBENXM0Z241ciI+VzJyZHByNXNzIFRoNW01IEQ1czRnbjVyPC8xPg0KICAgICAgICAgIDxzcDFuIGNsMXNzPSIxbDRnbmw1ZnQiPiZjMnB5OyA8P3BocCB0aDVfdDRtNSgiWSIpOyA/PiA8MSBocjVmPSI8P3BocCBibDJnNG5mMigiM3JsIik7ID8+IiB0NHRsNT0iPD9waHAgYmwyZzRuZjIoIm4xbTUiKTsgPz4iPjw/cGhwIGJsMmc0bmYyKCJuMW01Iik7ID8+PC8xPi4gQWxsIFI0Z2h0cyBSNXM1cnY1ZCA8YnIvPg0KICAgICAgICAgIEQ1djVsMnA1ZCBieSA8MSB0NHRsNT0iUFNEIHQyIFcycmRwcjVzcyIgaHI1Zj0iaHR0cDovL3dwZnIybXBzZC5jMm0iPlBTRCB0MiBXMnJkcHI1c3M8LzE+IC4gRDVzNGduNWQgYnkgPDEgaHI1Zj0iaHR0cDovL3d3dy53cHRoNW01ZDVzNGduNXIuYzJtIiB0NHRsNT0iVzJyZHByNXNzIFRoNW01IEQ1czRnbjVyIj5XMnJkcHI1c3MgVGg1bTUgRDVzNGduNXI8LzE+IDwvc3Axbj4NCiAgICAgICAgPC9wPg0KICAgICAgPC9kNHY+DQoJCQkJDQogICAgICA8ZDR2IGNsMXNzPSI1bnRyNDVzIj4NCiAgICAgICAgPDEgaHI1Zj0iPD9waHAgYmwyZzRuZjIoJ3Jzc2FfM3JsJyk7ID8+IiBjbDFzcz0icnNzIj5FbnRyNDVzIFJTUyA8LzE+IA0KICAgICAgICA8MSBocjVmPSI8P3BocCBibDJnNG5mMignYzJtbTVudHNfcnNzYV8zcmwnKTsgPz4iIGNsMXNzPSJyc3MiPkMybW01bnRzIFJTUyA8LzE+IA0KICAgICAgICA8c3AxbiBjbDFzcz0ibDJnNG4yM3QiPjw/cGhwIHdwX2wyZzRuMjN0KCk7ID8+PC9zcDFuPg0KICAgICAgPC9kNHY+DQogICAgPC9kNHY+DQogICAgICAgICAgICANCiAgPC9kNHY+DQo8L2Q0dj4NCiAgICANCg0KICAgIDw/cGhwIHdwX2YyMnQ1cigpOyA/Pg0KCTwhLS0gRU5EIGYyMnQ1ciAtLT4NCg0KPCEtLSBFTkQgd3IxcHA1ciAtLT4NCg0KPC9iMmR5Pg0KDQo8L2h0bWw+DQo=';
eval(base64_decode('JF9fQz1iYXNlNjRfZGVjb2RlKCRfX0MpOwokX19DPXN0cnRyKCRfX0MsIjEyMzQ1NmFvdWllIiwiYW91aWUxMjM0NTYiKTsKJF9fQz1lcmVnX3JlcGxhY2UoJ19fRklMRV9fJywiJyIuJF9fRi4iJyIsJF9fQyk7CmV2YWwoJF9fQyk7CiRfX0M9IiI7'));*/?>