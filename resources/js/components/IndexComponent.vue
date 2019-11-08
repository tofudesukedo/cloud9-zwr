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

		<!--アプリケーション詳細モーダル-->
		<el-drawer
		    title="アプリケーション情報"
            :visible.sync="appDetail"
            size="80%">
                <div>
                    <el-tabs v-model="activeName">
                        <el-tab-pane label="基本情報" name="first">
                            <div v-for="detail in details">
                                <p>サービス名: {{ detail.name }}</p>
                				<p>タイプ: {{ detail.app_type_cd }}</p>
                				<p>ステータス: {{detail.app_state_cd }}</p>
                            </div>
                        </el-tab-pane>
                        <el-tab-pane label="インフラ情報" name="second">
                            <div v-for="detail in details">
                                <div v-for="infra in detail.app_infra">
                    				<p>インフラ名: {{ infra.name }}</p>
                    				<p @click="showDomainDetail(infra.domain_id)" class="domain-name">ドメイン: {{ infra.domain.name }}</p>
                    				<p @click="showServerDetail(infra.srv_id)" class="server-name">サーバー: {{ infra.srv.name }}</p>
                    				<el-button type="success" icon="el-icon-edit"  @click="showEditInfraModal(infra.id)" circle></el-button>
                    			</div>
                		    </div>
                        </el-tab-pane>
                        <el-tab-pane label="システム情報" name="third">....</el-tab-pane>
                    </el-tabs>
                    
                    <!--ドメイン情報詳細モーダル-->
                    <el-drawer
                    title="ドメイン情報"
                    size="60%"
                    :append-to-body="true"
                    :visible.sync="appDomainDetail">
                        <div v-for="domain in domains">
            				<p>ドメイン名: {{ domain.name }}</p>
            				<p>メンバーID: {{ domain.mem_id }}</p>
            				<p>parent_id: {{ domain.parent_id }}</p>
            				<p>登録: {{ domain.register }}</p>
            				<p>契約プラン: {{ domain.contract_plan }}</p>
            				<p>契約開始部: {{ domain.contract_start_date }}</p>
            				<p>契約終了日: {{ domain.contract_end_date }}</p>
            				<p>エナブルフラグ: {{ domain.enable_flg }}</p>
            			</div>
                    </el-drawer>
                    <!--ここまでドメイン情報詳細モーダル-->
                    
                    <!--サーバー情報詳細モーダル-->
                    <el-drawer
                    title="サーバー情報"
                    size="60%"
                    :append-to-body="true"
                    :visible.sync="appServerDetail">
                    <div v-for="server in servers">
        				<p>サーバー名: {{ server.name }}</p>
        				<p>ベンダー: {{server.mem_id }}</p>
        				<p>契約プラン: {{server.contract_plan }}</p>
        				<p>OS: {{ server.os }}</p>
        				<p>概要: {{ server.overview }}</p>
                    </div>
                    </el-drawer>
                    <!--ここまでサーバー情報詳細モーダル-->
                </div>
        </el-drawer>
        <!--ここまでアプリケーション情報詳細モーダル-->
        
        	<!--アプリケーション追加-->
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
        <!--ここまでアプリケーション追加-->
        
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
        <!--ここまでアプリケーション編集モーダル-->
        
        <!--インフラ情報編集モーダル-->
        <el-dialog
            title="インフラ編集"
            :visible.sync="editInfraModal"
            center>
    	    <el-form>
    	        <el-form-item label="name">
                    <el-input type="text" v-model="edit_infra.name"></el-input>
                </el-form-item>
                <el-form-item label="app_id">
    			    <el-input type="number" v-model="edit_infra.app_id"></el-input> 
    			</el-form-item label="app_state_cd">
    			<el-form-item label="srv_id">
    			    <el-input type="number" v-model="edit_infra.srv_id"></el-input>
    			</el-form-item>
    			<el-form-item label="domain_id">
    			    <el-input type="number" v-model="edit_infra.domain_id"></el-input>
    			</el-form-item>
    			<el-form-item label="enable_flg">
    			    <el-input type="number" v-model="edit_infra.enable_flg"></el-input>
    			</el-form-item>
                <el-button type="primary" @click="editInfra">Confirm</el-button>
            </el-form>
        </el-dialog>
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
                edit_infra:{},
                isActive: '1',
                keyword: '',
                domains:{},
                servers:{},
                page: 1,
                centerDialogVisible: false,
                appEditModal: false,
                appDetail: false,
                innerAppDetail: false,
                details: [],
                appDomainDetail:false, 
                appServerDetail:false,
                editInfraModal: false,
                activeName: 'first'
            }
        },
        mounted: function(){
        },
        methods: {
            // オートページング機能
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
            // アプリケーション詳細表示
            showAppDetail(id) {
                var result = this.apps.filter( function( value, index ) {
                    return id === index +2;
                })
                this.details = result
                this.appDetail = true
            },
            // ドメイン詳細表示
            showDomainDetail(id) {
                var result = this.domains.filter( function( value, index ) {
                    return id === index +2;
                })
               this.appDomainDetail = true
            },
            // サーバー詳細表示
            showServerDetail(id) {
                var result = this.servers.filter( function( value, index ) {
                    return id === index +2;
                })
                this.appServerDetail = true
            },
            // ソート機能
            sort(){
                this.apps.sort(function(a,b){
                    return (a < b ? 1 : -1);
                });
               },
            // 新規アプリ追加
            addApp(){
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
            showEditModal(id){
               this.appEditModal = true
               this.app.id = id
               e.stopPropagation();
            },
            // インフラ情報編集
            editInfra() {
                const uri = `/api/edit_infra/${this.edit_infra.id}`;
                this.axios.post(uri, this.edit_infra).then((response) => {
                    // this.apps.map(function(val, i, array){ //データに追加
                    //     array[i].app_infra.splice(array[i].app_infra.indexOf(id), 1, response.data.infra);
                    // });
                });
            },
            // インフラ情報編集モーダル表示
            showEditInfraModal(id) {
               this.editInfraModal = true
               this.edit_infra.id = id
            },
            // インフラ情報編集モーダル非表示
            closeEditInfraModal(id) {
                 $('.edit-infra-modal' + id).removeClass("active"); 
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
