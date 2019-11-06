<template>
    <div class="index">
        
        <!--メイン-->
    	<div class="app-content">
    		<ul class="app-header">
    			<li><button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">追加</button> <span class="btn btn-primary">CSVファイル</span> </li>
    			<li>
    			    <input type="text" class="form-control search-query span3" v-model="keyword" placeholder="Search">
    			    <button class="ml-3 btn btn-outline-success" v-on:click.prevent="search()">
                        Search
                    </button>
                </li>
    		</ul>
    		<div>
    			<h1>アプリケーション</h1>
    			<table class="table table-hover">
    				<thead>
    					<tr>
    						<th>ID</th>
    						<th>Name</th>
    						<th>Edit</th>
    						<th>Delete</th>
    					</tr>
    				</thead>
    				<draggable tag="tbody">
        					 <tr @click="detailShow(app.id)" v-for="app in apps" :key="app.id">
        						<td>{{ app.id }}</td>
        						<td>{{ app.name }}</td>
        						<td><button class="btn btn-success" data-toggle="modal" @click="showEditModal(app.id, $event)">Edit</button></td>
        						<td><button class="btn btn-danger" @click="deleteApp(app.id, $event)">Delete</button></td>
        					</tr>
    				</draggable>
    				<!--ページネーション-->
    				<ul class="pagination navigation example">
                      <li :class="{disabled: current_page <= 1}" class="page-item"><a class="page-link" href="#" @click="change(1)">&laquo;</a></li>
                      <li :class="{disabled: current_page <= 1}" class="page-item"><a class="page-link" href="#" @click="change(current_page - 1)">&lt;</a></li>
                      <li v-for="page in pages" :key="page" :class="{active: page === current_page}" class="page-item">
                        <a @click="change(page)" class="page-link">{{page}}</a>
                      </li>
                      <li :class="{disabled: current_page >= last_page}" class="page-item"><a class="page-link" href="#" @click="change(current_page + 1)">&gt;</a></li>
                      <li :class="{disabled: current_page >= last_page}" class="page-item"><a class="page-link" href="#" @click="change(last_page)">&raquo;</a></li>
                    </ul>
                    <!--ページネーション-->
    			</table>
    		</div>
    	</div>
    	<!--ここまでメイン-->
    	
        <!--アプリケーション追加-->
		<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-name" id="exampleModalLabel">アプリケーションの追加</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> 
                    </div>
					<form @submit.prevent="addApp">
						<div class="modal-body">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group"> <label>App Name:</label> <input type="text" class="form-control" v-model="app.name"> </div>
									<div class="form-group"> <label>service_id:</label> <input type="number" class="form-control" v-model="app.service_id"> </div>
									<div class="form-group"> <label>app_state_cd:</label> <input type="number" class="form-control" v-model="app.app_state_cd"> </div>
									<div class="form-group"> <label>app_type_cd:</label> <input type="number" class="form-control" v-model="app.app_type_cd"> </div>
									<div class="form-group"> <label>enable_flg</label>x <input type="number" class="form-control" v-model="app.enable_flg"> </div>
								</div>
							</div>
						</div>
						<div class="modal-footer"> <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> <button type="submit" class="form-group btn btn-primary">Save changes</button> </div>
					</form>
				</div>
			</div>
		</div>
		<!--ここまで新規アプリケーション追加-->
	
    	<!--詳細スライド-->
    	<div v-for="app in apps">
        	<div :class="'app-detail'+ app.id + ' ' + 'app-details'">
        		<div class="row"> 
        		    <button @click="closeDetail(app.id)" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <ul class="tabs">
                        <li @click="tabChange('1')" v-bind:class="{'active': isActive === '1'}">基本情報</li>
                        <li @click="tabChange('2')" v-bind:class="{'active': isActive === '2'}">インフラ情報</li>
                        <li @click="tabChange('3')" v-bind:class="{'active': isActive === '3'}">システム情報</li>
                    </ul>
            
                    <ul class="contents">
                        <div v-if="isActive === '1'">
                            <h3>アプリケーション基本情報</h3>
        				    <p>サービス名: {{ app.name }}</p>
        				    <p>タイプ: {{ app.app_type_cd }}</p>
        				    <p>ステータス: {{app.app_state_cd }}</p>
                        </div>
                        <div v-if="isActive === '2'">
                            <div v-for="infra in app.app_infra">
                                <h3>インフラ情報</h3>
                				<p>インフラ名: {{ infra.name }}</p>
                				<p @click="domainShow(infra.domain_id)" class="domain-name">ドメイン: {{ infra.domain.name }}</p>
                				<p @click="serverShow(infra.srv_id)" class="server-name">サーバー: {{ infra.srv.name }}</p>
                				<button class="btn btn-success" data-toggle="modal" @click="showEditInfraModal(infra.id)">Edit</button>
                			</div>
                        </div>
                        <div v-if="isActive === '3'">
                            <h3>システム基本情報</h3>
            				<p>サービス名: {{ app.name }}</p>
            				<p>タイプ: {{app.app_type_cd }}</p>
            				<p>ステータス: {{app.app_state_cd }}</p>
                        </div>
                    </ul>
        		</div>
        	</div>
    	</div>
    	<!--ここまで詳細スライド-->
    	
    	<!--ドメインスライド-->
    	<div v-for="domain in domains">
        	<div :class="'domain-detail'+ domain.id + ' ' + 'domain-details'">
        		<div class="row"> 
                    <div>
                        <h3>ドメイン情報</h3>
        				<p>ドメイン名: {{ domain.name }}</p>
        				<p>登録: {{ domain.register }}</p>
        				<p>契約プラン: {{ domain.contract_plan }}</p>
        				<button class="btn btn-secondary" @click="closeDomainDetail(domain.id)">
                            <span aria-hidden="true">戻る</span>
                        </button>
                    </div>
        		</div>
        	</div>
    	</div>
    	<!--ここまでドメインスライド-->
    	
    	<!--サーバースライド-->
    	<div v-for="server in servers">
        	<div :class="'server-detail'+ server.id + ' ' + 'server-details'">
        		<div class="row"> 
                    <div>
                        <h3>サーバー基本情報</h3>
        				<p>サーバー名: {{ server.name }}</p>
        				<p>ベンダー: {{server.vendor }}</p>
        				<p>契約プラン: {{server.contract_plan }}</p>
        				<p>OS: {{ server.os }}</p>
        				<p>概要: {{ server.overview }}</p>
        				<button class="btn btn-secondary" @click="closeServerDetail(server.id)">
                            <span aria-hidden="true">戻る</span>
                        </button>
                    </div>
        		</div>
        	</div>
    	</div>
    	<!--ここまでサーバースライド-->
    	
        <!--編集モーダル-->
    	<div v-for="app in apps" :class="'edit-modal'+ app.id + ' ' + 'edit-modal'">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-name" id="exampleModalLabel">アプリケーションの編集</h5> 
						<button @click="closeEditModal(app.id, $event)" type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> 
                    </div>
					<form @submit.prevent="editApp(app.id)">
						<div class="modal-body">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group"> <label>App Name:</label> <input type="text" class="form-control" v-model="app_edit.name"> </div>
            						<div class="form-group"> <label>service_id:</label> <input type="number" class="form-control" v-model="app_edit.service_id"> </div>
            						<div class="form-group"> <label>app_state_cd:</label> <input type="number" class="form-control" v-model="app_edit.app_state_cd"> </div>
            						<div class="form-group"> <label>app_type_cd:</label> <input type="number" class="form-control" v-model="app_edit.app_type_cd"> </div>
            						<div class="form-group"> <label>enable_flg</label>x <input type="number" class="form-control" v-model="app_edit.enable_flg"> </div>
								</div>
							</div>
						</div>
						<div class="modal-footer"> <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> <button type="submit" class="form-group btn btn-primary">Save changes</button> </div>
					</form>
				</div>
			</div>
		</div>
		<!--ここまで編集モーダル-->
		
		<!--インフラ情報編集モーダル-->
    	<div v-for="app in apps">
			<div v-for="infra in app.app_infra" :class="'edit-infra-modal'+ infra.id + ' ' + 'edit-infra-modal'" role="document" >
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-name" id="exampleModalLabel">インフラ情報の編集</h5> 
						<button @click="closeEditInfraModal(infra.id)" type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> 
                    </div>
					<form @submit.prevent="editInfra(infra.id)">
						<div class="modal-body">
							<div class="row">
								<div class="col-md-12">
									<div class="form-group"> <label>Infra Name:</label> <input type="text" class="form-control" v-model="infra_edit.name"> </div>
            						<div class="form-group"> <label>server_id:</label> <input type="number" class="form-control" v-model="infra_edit.srv_id"> </div>
            						<div class="form-group"> <label>domain_id:</label> <input type="number" class="form-control" v-model="infra_edit.domain_id"> </div>
            						<div class="form-group"> <label>enable_flg</label>x <input type="number" class="form-control" v-model="infra_edit.enable_flg"> </div>
								</div>
							</div>
						</div>
						<div class="modal-footer"> <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> <button type="submit" class="form-group btn btn-primary">Save changes</button> </div>
					</form>
				</div>
			</div>
		</div>
		<!--ここまでインフラ情報編集モーダル-->
		
    </div>
</template>

<script>
    import draggable from 'vuedraggable';
    export default{
        name: 'app',
        components: {
            draggable,
        },
        data() {
            return {
                apps: [],
                app:{},
                app_edit:{},
                infra_edit:{},
                isActive: '1',
                keyword: '',
                domains:{},
                servers:{},
                current_page: 1,
                last_page: 1,
                total: 1,
                from: 0,
                to: 0
            }
        },
        mounted: function(){
            this.load(1)
        },
        methods: {
            // ページネーション
            load(page) {
                axios.get('/api/app_index?page=' + page).then((response) => {
                    this.apps = response.data.apps.data
                    this.current_page = response.data.apps.current_page
                    this.last_page = response.data.apps.last_page
                    this.total = response.data.apps.total
                    this.from = response.data.apps.from
                    this.to = response.data.apps.to
                    this.domains = response.data.domains;
                    this.servers = response.data.servers;
                })
            },
            change(page) {
                if (page >= 1 && page <= this.last_page)
                this.load(page)
            },
            // 新規アプリ追加
            addApp(){
                const uri = '/api/app_create';
                this.axios.post(uri, this.app).then((response) => {
                    this.apps.push(response.data.app)
               });
            },
            // アプリ編集
            editApp(id){
                const uri = `/api/app_edit/${id}`;
                this.axios.post(uri, this.app_edit).then((response) => {
                    this.apps.splice(this.apps.indexOf(id), 1, response.data.app);
                });
            },
            // アプリケーション削除
            deleteApp(id,e){
                 const uri = `/api/app_delete/${id}`;
                 this.axios.delete(uri).then(response => {
                     this.apps.splice(this.apps.indexOf(id), 1);
                 });
                 e.stopPropagation();
            },
            // 編集モーダル表示
            showEditModal(id,e){
                $('.edit-modal' + id).addClass("active");
                $('.app-content').addClass("active");
                e.stopPropagation();
            },
            // 編集モーダル非表示
            closeEditModal(id,e){
                $('.edit-modal' + id).removeClass("active");
                $('.app-content').removeClass("active");
                e.stopPropagation();
            },
            // インフラ情報編集
            editInfra(id) {
                const uri = `/api/edit_infra/${id}`;
                this.axios.post(uri, this.infra_edit).then((response) => {
                    // this.apps.map(function(val, i, array){ //データに追加
                    //     array[i].app_infra.splice(array[i].app_infra.indexOf(id), 1, response.data.infra);
                    // });
                });
            },
            // インフラ情報編集モーダル表示
            showEditInfraModal(id) {
                 $('.edit-infra-modal' + id).addClass("active");
            },
            // インフラ情報編集モーダル非表示
            closeEditInfraModal(id) {
                 $('.edit-infra-modal' + id).removeClass("active"); 
            },
            // アプリケーション詳細表示
            detailShow(id) {
                $('.app-detail' + id).addClass("active");
                $('.app-content').addClass("active");
            },
            // 詳細表示
            domainShow(id) {
                $('.domain-detail' + id).addClass("active");
            },
            // 詳細表示
            serverShow(id) {
                $('.server-detail' + id).addClass("active");
            },
            // 詳細非表示
            closeDetail(id) {
                $('.app-detail' + id).removeClass("active");
                $('.app-content').removeClass("active");
            },
            closeServerDetail(id) {
                $('.server-detail' + id).removeClass("active");
            },
            closeDomainDetail(id) {
                $('.domain-detail' + id).removeClass("active");
            },
            // タブ切り替え
            tabChange(num){
              this.isActive = num
            },
            // 検索
            search() {
                axios.post('/api/app_search/'+ this.keyword)
                .then(res => {
                    this.apps = res.data.apps;
                    console.log(res.data);
                })
                .catch(error => {
                    console.log('データの取得に失敗しました。');
                });
            },
        },
        computed: {
            pages() {
                let start = _.max([this.current_page - 2, 1])
                let end = _.min([start + 5, this.last_page + 1])
                start = _.max([end - 5, 1])
                return _.range(start, end)
            },
        }
    }
</script>
