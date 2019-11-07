<template>
    <div class="index">
        
        <!--メイン-->
    	<div class="app-content">
    	    <h1>アプリケーション一覧</h1>
    		<ul class="app-header">
    			<li><el-button type="primary" @click="centerDialogVisible = true">追加</el-button></li>
    			<li>
    			    <input type="text" class="form-control search-query span3" v-model="keyword" placeholder="Search">
    			    <button class="ml-3 btn btn-outline-success" v-on:click.prevent="search()">
                        Search
                    </button>
                </li>
    		</ul>
    		<div>
    			<table class="table table-hover">
    				<thead>
    					<tr>
    						<th>ID<el-button  class="ml-3" size="min" icon="el-icon-upload2" @click="sort()"></el-button></th>
    						<th>Name</th>
    						<th>Edit</th>
    						<th>Delete</th>
    						<th>Detail</th>
    					</tr>
    				</thead>
    				<draggable tag="tbody">
    					 <tr v-for="app in apps" :key="app.id">
    						<td>{{ app.id }}</td>
    						<td>{{ app.name }}</td>
    						<td><el-button type="success" icon="el-icon-edit" @click="showEditModal(app.id, $event)" circle></el-button></td>
    						<td><el-button type="danger" icon="el-icon-delete" @click="deleteApp(app.id, $event)" circle></el-button></td>
    						<td>
    						    <el-button @click="showAppDetail(app.id)">
                                    詳細
                                </el-button>
                            </td>
    					</tr>
    					<infinite-loading @infinite="infiniteHandler"></infinite-loading>
    				</draggable>
    			</table>
    		</div>
    	</div>
    	<!--ここまでメイン-->
    	
    	<el-dialog
          title="アプリケーション追加"
          :visible.sync="centerDialogVisible"
          center>
    	    <el-form>
    	        <el-form-item label="application name">
                    <el-input type="text" v-model="app.name"></el-input>
                </el-form-item>
                <el-form-item label="service_id">
    			    <el-input type="number" v-model="app.service_id"></el-input> 
    			</el-form-item label="app_state_cd">
    			    <el-input type="number" v-model="app.app_state_cd"></el-input>
    			</el-form-item>
    			<el-form-item label="app_type_cd">
    			    <el-input type="number" v-model="app.app_type_cd"></el-input>
    			</el-form-item>
    			<el-form-item label="enable_flg">
    			    <el-input type="number" v-model="app.enable_flg"></el-input>
    			</el-form-item>
                <el-button type="primary" @click="addApp">Confirm</el-button>
            </el-form>
        </el-dialog>
        
        <!--編集モーダル-->
        <el-dialog
          title="アプリケーション編集"
          :visible.sync="appEditModal"
          center>
    	    <el-form>
    	        <el-form-item label="application name">
                    <el-input type="text" v-model="app_edit.name"></el-input>
                </el-form-item>
                <el-form-item label="service_id">
    			    <el-input type="number" v-model="app_edit.service_id"></el-input> 
    			</el-form-item label="app_state_cd">
    			<el-form-item label="app_state_cd">
    			    <el-input type="number" v-model="app_edit.app_state_cd"></el-input>
    			</el-form-item>
    			<el-form-item label="app_type_cd">
    			    <el-input type="number" v-model="app_edit.app_type_cd"></el-input>
    			</el-form-item>
    			<el-form-item label="enable_flg">
    			    <el-input type="number" v-model="app_edit.enable_flg"></el-input>
    			</el-form-item>
                <el-button type="primary" @click="appEdit">Confirm</el-button>
            </el-form>
        </el-dialog>
        <!--ここまで編集モーダル-->
	
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
		
		<el-drawer
		    title="アプリケーション情報"
            :visible.sync="appDetail"
            size="80%">
                <div>
                    <ul class="tabs">
                        <li @click="tabChange('1')" v-bind:class="{'active': isActive === '1'}">基本情報</li>
                        <li @click="tabChange('2')" v-bind:class="{'active': isActive === '2'}">インフラ情報</li>
                        <li @click="tabChange('3')" v-bind:class="{'active': isActive === '3'}">システム情報</li>
                    </ul>
            
                    <ul class="contents">
                        <div v-if="isActive === '1'">
                            <h3>アプリケーション基本情報</h3>
        				    <div v-for="detail in details">
                                <p>サービス名: {{ detail.name }}</p>
                				<p>タイプ: {{ detail.app_type_cd }}</p>
                				<p>ステータス: {{detail.app_state_cd }}</p>
                            </div>
                        </div>
                        <div v-if="isActive === '2'">
                             <div v-for="detail in details">
                                 <div v-for="infra in detail.app_infra">
                    				<p>インフラ名: {{ infra.name }}</p>
                    				<el-button @click="showDomainDetail(infra.domain_id)">ドメイン: {{ infra.domain.name }}</el-button>
                    				<el-button @click="showServerDetail(infra.srv_id)">サーバー: {{ infra.srv.name }}</el-button>
                    				<button class="btn btn-success" @click="showEditInfraModal(infra.id)">Edit</button>
                    			</div>
                		    </div>
                        </div>
                        <div v-if="isActive === '3'">
                            <h3>システム基本情報</h3>
                        </div>
                    </ul>
                    <el-drawer
                    title="ドメイン情報"
                    size="60%"
                    :append-to-body="true"
                    :visible.sync="appDomainDetail">
                        <div v-for="detail in details">
                             <div v-for="infra in detail.app_infra">
                				<p>インフラ名: {{ infra.name }}</p>
                				<p @click="domainShow(infra.domain_id)" class="domain-name">ドメイン: {{ infra.domain.name }}</p>
                				<p @click="serverShow(infra.srv_id)" class="server-name">サーバー: {{ infra.srv.name }}</p>
                				<button class="btn btn-success" @click="showEditInfraModal(infra.id)">Edit</button>
                			</div>
                		</div>
                    </el-drawer>
                    <el-drawer
                    title="サーバー情報"
                    size="60%"
                    :append-to-body="true"
                    :visible.sync="appServerDetail">
                    <div v-for="server in servers">
        				<p>サーバー名: {{ server.name }}</p>
        				<p>ベンダー: {{server.vendor }}</p>
        				<p>契約プラン: {{server.contract_plan }}</p>
        				<p>OS: {{ server.os }}</p>
        				<p>概要: {{ server.overview }}</p>
                    </div>
                    </el-drawer>
                </div>
        </el-drawer>

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
                page: 1,
                centerDialogVisible: false,
                appEditModal: false,
                appDetail: false,
                innerAppDetail: false,
                details: [],
                appDomainDetail:false, 
                appServerDetail:false
            }
        },
        mounted: function(){
        },
        methods: {
            infiniteHandler($state) {
                axios.get('/api/app_index', {
                    params: {
                        page: this.page,
                        per_page: 1
                    },
                }).then((response) => {
                    this.domains = response.data.domains;
                    this.servers = response.data.servers;
                    if (this.page < response.data.apps.data.length) {
                        this.page += 1
                        this.apps.push(...response.data.apps.data)
                        $state.loaded()
                    } else {
                        $state.complete()
                    }
                }).catch((err) => {
                    $state.complete()
                })
            },
            showAppDetail(id) {
                var result = this.apps.filter( function( value, index ) {
                    return id === index +2;
                })
                this.details = result
                this.appDetail = true
            },
            showDomainDetail(id) {
                var result = this.domains.filter( function( value, index ) {
                    return id === index +2;
                })
               this.appDomainDetail = true
            },
            showServerDetail(id) {
                var result = this.servers.filter( function( value, index ) {
                    return id === index +2;
                })
                this.appServerDetail = true
            },
            sort(){
                this.apps.sort(function(a,b){
                    return (a < b ? 1 : -1);
                });
               },
            // 新規アプリ追加
            addApp(){
                console.log('aaa');
                const uri = '/api/app_create';
                this.axios.post(uri, this.app).then((response) => {
                    this.apps.push(response.data.app)
               });
            },
            // アプリ編集
            appEdit(id){
                const uri = `/api/app_edit/${this.app.id}`;
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
               this.appEditModal = true
               this.app.id = id
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
            // detailShow(id) {
            //     $('.app-detail' + id).addClass("active");
            //     $('.app-content').addClass("active");
            // },
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
                })
                .catch(error => {
                    console.log('データの取得に失敗しました。');
                });
            },
        },
    }
</script>
