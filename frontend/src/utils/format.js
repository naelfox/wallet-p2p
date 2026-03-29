export const formatCurrency = (value) =>
  new Intl.NumberFormat('pt-BR', {
    style: 'currency',
    currency: 'BRL',
  }).format((Number(value ?? 0)) / 100)

export const formatDate = (value) =>
  new Intl.DateTimeFormat('pt-BR', {
    dateStyle: 'short',
    timeStyle: 'short',
  }).format(new Date(value))


export const formatTransactionType = (type) => {
  const map = {
    debit: 'Enviado',
    credit: 'Recebido'
  }

  return map[type] || type
}