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
    				<tbody>
    					<tr @click="detailShow(app.id)" v-for="app in apps" :key="app.id">
    						<td>{{ app.id }}</td>
    						<td>{{ app.name }}</td>
    						<td><button class="btn btn-success" data-toggle="modal" @click="showEditModal(app.id, $event)">Edit</button></td>
    						<td><button class="btn btn-danger" @click="deleteApp(app.id, $event)">Delete</button></td>
    					</tr>
    				</tbody>
    			</table>
    		</div>
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
    	</div>
    	<!--ここまでメイン-->
    	
    	<!--詳細スライド-->
    	<div v-for="app in apps">
        	<div :class="'app-detail'+ app.id + ' ' + 'app-details'">
        		<div class="row"> 
        		    <button @click="closeDetail(app.id)" type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <ul class="tabs">
                        <li @click="tabChange('1')" v-bind:class="{'active': isActive === '1'}">タブ1</li>
                        <li @click="tabChange('2')" v-bind:class="{'active': isActive === '2'}">タブ2</li>
                        <li @lick="tabChange('3')" v-bind:class="{'active': isActive === '3'}">タブ3</li>
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
                				<p>ドメイン: {{ infra.domain_id }}</p>
                				<p>サービス: {{ infra.srv_id }}</p>
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
		
    </div>
</template>

<script>
    export default{
        data() {
            return {
               apps: [],
               app:{},
               app_edit:{},
               isActive: '1',
               keyword: ''
            }
        },
        mounted: function(){
            const uri = "/api" + this.$route.path;
                this.axios.get(uri).then(response => {
                    this.apps = response.data.apps;
                    console.log(response.data);
                });
        },
        methods: {
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
            // アプリケーション詳細表示
            detailShow(id) {
                $('.app-detail' + id).addClass("active");
                $('.app-content').addClass("active");
            },
            // 詳細非表示
            closeDetail(id) {
                $('.app-detail' + id).removeClass("active");
                $('.app-content').removeClass("active");
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
            }
        },
    }
</script>
