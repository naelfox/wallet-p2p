import {
  defineStore
} from 'pinia'
import * as transferService from '@/services/transferService'


export const useTransferStore = defineStore('transfer', {

  actions: {
    async transfer(payload) {
      if (!payload.recipient_email || !payload.amount) {
        throw new Error('Email e valor são obrigatórios para realizar a transferência');
      }

      if (payload.amount <= 0) {
        throw new Error('O valor da transferência deve ser maior que zero');
      }

      return await transferService.transfer(payload)
    }
  }
})