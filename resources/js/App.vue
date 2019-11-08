<template>
    <div>
        <el-container>
             <el-aside width="200px">
                <div>
                    <div style="margin: 40px;">
                        <router-link to="/" style="display: block;" class="mb-3">Home</router-link>
                        <router-link to="/app_index" style="display:block;" class="mb-3">アプリケーション一覧</router-link>
                        <p>today</p>
                        <p>news</p>
                        <p>create newb board</p>
                        <p>recently read</p>
                        <p>intergration</p>
                    </div>
                </div>
            </el-aside>
            <el-main>
                <div>
                    <router-view></router-view>
                </div>
            </el-main>
        </el-container>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>