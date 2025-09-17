<template>

  
      <div class="grid grid-cols-12 gap-6 px-6 py-6">
        <!-- Recent Threads (Right Side) -->
        <div class="col-span-9 order-2">
          <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-semibold">Recent Threads</h2>
            <select class="border rounded-md px-2 py-1 text-sm">
              <option>Latest</option>
              <option>Popular</option>
            </select>
          </div>

          <!-- Thread Card -->
          <div v-for="thread in threads" :key="thread.id" class="border rounded-md p-4 mb-4 hover:shadow">
            <div class="flex items-center gap-2 mb-2">
                <!-- Avatar -->
                <Link :href="route('users.show',thread.user.id)" 
                class="w-7 h-7 bg-blue-100 rounded-full flex items-center justify-center">
                <span class="text-blue-600 font-semibold text-sm">
                {{ thread.user?.name ? thread.user.name.charAt(0).toUpperCase() : 'A' }}
                </span>
                </Link>

                <!-- Category -->
                <span class="text-xs bg-blue-100 text-blue-600 px-2 py-0.5 rounded">
                {{ thread.category?.name }}
                </span>

                <!-- Time -->
                <span class="text-xs text-gray-600">
                {{ moment(thread.created_at,"YYYYMMDD").fromNow() }}
                </span>
            </div>

            <Link prefetch :href="route('threads.show', thread.id)" class="block text-lg font-semibold mt-2 text-gray-800">{{ thread.title }}</Link>
            <p class="text-sm text-gray-600 mt-1 line-clamp-2">
              {{ thread.body }}
            </p>
            <div class="flex items-center justify-between text-sm text-gray-500 mt-3">
              <div>24 replies • 1.2k views</div>
              <div class="flex items-center gap-3">
              <span>by {{ thread.user.name }}</span>
            
            <Link :href="route('threads.edit', thread.id)"
            v-if="$page.props.auth?.user && thread.threadActionAuthorized"
            type="button"
            class="inline-flex items-center px-3 py-1.5 rounded-md text-sm font-medium text-blue-700 border border-blue-300 hover:bg-red-50 transition-colors"
            >
            Edit
            </Link>

            <button
            v-if="$page.props.auth?.user && thread.threadActionAuthorized"
            type="button"
            class="inline-flex items-center px-3 py-1.5 rounded-md text-sm font-medium text-red-700 border border-red-300 hover:bg-red-50 transition-colors"
            @click="openDeleteModal(thread)"
            >
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M15 7V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3" />
            </svg>
            Delete
            </button>
            
              </div>
            </div>
          </div>
        </div>   
    </div>

    <!-- Delete Confirmation Modal -->
    <Modal :show="showDeleteModal" @close="closeDeleteModal">
    <div class="p-6">
      <div class="sm:flex sm:items-start">
        <!-- Red warning icon -->
        <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
          <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M15 7V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3" />
          </svg>
        </div>

        <!-- Text -->
        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
          <h3 class="text-lg leading-6 font-medium text-gray-900">Delete thread</h3>
          <div class="mt-2">
            <p class="text-sm text-gray-500">
              Are you sure you want to delete
              <span class="font-semibold text-gray-700">"{{ threadToDelete?.title }}"</span>?
              This action cannot be undone.
            </p>
          </div>
        </div>
      </div>

      <!-- Buttons -->
      <div class="mt-6 sm:mt-5 sm:flex sm:flex-row-reverse sm:space-x-reverse sm:space-x-3">
        <button
          type="button"
          class="inline-flex w-full justify-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:ml-3 sm:w-auto"
          @click="confirmDelete"
        >
          Delete
        </button>
        <button
          type="button"
          class="mt-3 inline-flex w-full justify-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 sm:mt-0 sm:w-auto"
          @click="closeDeleteModal"
        >
          Cancel
        </button>
      </div>
    </div>
</Modal>


</template>


<script>
import moment  from 'moment';
import {Link} from '@inertiajs/vue3';
import Modal from '@/Components/Modal.vue';
export default {
    name : 'Welcome',
    components : {Link},
    components:{Link, Modal},
    props : {
        threads: {
            type : Array
        }
    },
    data(){
        return{
          showDeleteModal: false,
          threadToDelete: null,
        }
    },
    methods:{
      moment,
      openDeleteModal(thread){
        this.threadToDelete = thread;
        this.showDeleteModal = true;
      },
      closeDeleteModal(){
        this.showDeleteModal = false;
        this.threadToDelete = null;
      },
      confirmDelete(){
        this.$inertia.delete(route('threads.destroy', this.threadToDelete.id))
        this.closeDeleteModal();
      }
    },
    mounted(){
        console.log(this.threads);
    }
}
</script>

<style>

</style>