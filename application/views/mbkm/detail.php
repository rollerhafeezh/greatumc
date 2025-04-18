<div class="content__boxed">
    <div class="content__wrap">

    	<style>
    		.nav::-webkit-scrollbar {display: none}
    	</style>
    	<div class="row">
    		<div class="col-md">
		        <div class="tab-base">
		        	<ul class="nav nav-callout text-nowrap" id="myTab" style="flex-wrap: unset!important; overflow-x: auto; " role="tablist">
                <li class="nav-item d-block" role="presentation">
                    <button class="nav-link show active" data-bs-toggle="tab" data-bs-target="#aktivitas_mahasiswa" type="button" role="tab" aria-controls="aktivitas_mahasiswa" >Aktivitas Mahasiswa</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#peserta" type="button" role="tab" aria-controls="peserta" >Data Mahasiswa</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#pembimbing" type="button" role="tab" aria-controls="pembimbing" >Dosen Pembimbing</button>
                </li>
              </ul>

	            <div class="tab-content" style="border-top-right-radius: 0!important;">
	            	<?php $this->load->view('mbkm/tab_aktivitas_mahasiswa'); ?>
                <?php $this->load->view('mbkm/tab_mahasiswa'); ?>
                <?php $this->load->view('mbkm/tab_pembimbing'); ?>
				     </div>
		        </div>
    		</div>
    	</div>
    </div>
</div>

<datalist id="datalist_dosen">
  <?php foreach($dosen as $dosen): ?>
  <option value="<?= $dosen->nidn ?>"><?= $dosen->nm_sdm ?></option>
  <?php endforeach; ?>
</datalist>

<script>
  function castvote(index) {
    document.querySelectorAll('#nidn').forEach( el => {
        var datalist = el;
        var browserChildren = document.querySelector('#datalist_dosen').children

        var flag = false
        for(let i = 0; i < browserChildren.length; i++){
            flag = browserChildren[i].value === datalist.value || flag
        }

        if (!flag)
          datalist.value = ""
    })
  }
  
  document.querySelectorAll('button[data-bs-toggle="tab"]').forEach( el => {
    el.addEventListener('show.bs.tab', function(event) {
        localStorage.setItem('activeTab', event.target.getAttribute('data-bs-target'));
      })
  })

  var activeTab = localStorage.getItem('activeTab');
  if(activeTab){
    var triggerEl = document.querySelector('#myTab li button[data-bs-target="'+activeTab+'"]')
    var tab = new bootstrap.Tab(triggerEl)
    document.addEventListener("DOMContentLoaded", function(event) {
    	tab.show()
	});
  }
</script>
