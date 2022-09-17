<div class="modal-rkd">
	<div class="modal-rkd-body">
	<h2 class="modal-rkd-title" style="text-align:center">Please Don't close this tab</h2>
	<div class="modal-rkd-operation" style="text-align: center">
	<div id="myProgress">
 	 <div id="myBar"></div>
	</div>
	<br>
	<span id="modal-rkd-counter">0</span> imported of <span id="modal-rkd-total">200</span>
	<br>
	<br>
	</div>
	</div>
	<div class="modal-rkd-overlay"></div>
</div>

<style>
#myProgress {
  width: 100%;
  background-color: grey;
}

#myBar {
  width: 1%;
  height: 30px;
  background:linear-gradient(40deg,green,#08cdfb,green,#08cdfb,green,#08cdfb,green,#08cdfb,green,#08cdfb,green,#08cdfb,green,#08cdfb);
  background-position: inherit;
}

@keyframes mymove {
  0% {
      background-position: 0 0;
     }
  100% {
    background-position: calc(10*(15px/0.707)) 100%;
   }
}

.modal-rkd{
	display:none;
}
.modal-rkd-overlay {
  position: fixed;
  width: 100%;
  height: 100%;
  left: 0;
  top: 0;
  display: block;
  background: rgba(0,0,0,.5);
  z-index: 2000;
}

.modal-rkd-body {
  background: white;
  width: 500px;
  position: fixed;
  height: 200px;
  z-index: 20001;
  padding: 30px;
  box-shadow: 1px 1px 6px 1px black;
  left: calc(50vw - 500px / 2);
  top: calc(50vh - 200px / 2);
}
.modal-rkd-body h2{
  font: 20px arial;
  color: red;
}
.modal-rkd-operation{
  font: 25px arial;
}
.modal-rkd-operation span{
  color: green;
}

</style>
