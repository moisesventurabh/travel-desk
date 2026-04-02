// ─────────────────────────────────────────────────
// Tipos do domínio de Viagens
// ─────────────────────────────────────────────────

export type ViagemStatus = 'solicitado' | 'aprovado' | 'cancelado'

export interface Viagem {
  id: string
  solicitante: string
  destino: string
  dataIda: string      // ISO date: "2026-04-10"
  dataVolta: string    // ISO date: "2026-04-13"
  status: ViagemStatus
  objetivo?: string
  departamento?: string
  criadoEm: string     // ISO datetime
  userId: string
}

// Payload para criar um novo pedido
export interface CriarViagemPayload {
  solicitante: string
  destino: string
  dataIda: string
  dataVolta: string
  objetivo?: string
  departamento?: string
}

// Payload para atualizar status (admin)
export interface AtualizarStatusPayload {
  status: 'aprovado' | 'cancelado'
  observacao?: string
}

// Filtros da listagem
export interface ViagemFiltros {
  busca: string
  status: ViagemStatus | ''
  destino: string
  dataInicio: string
  dataFim: string
}

// Erros de validação do formulário
export type ViagemFormErrors = Partial<Record<keyof CriarViagemPayload, string>>

// Stats para o dashboard
export interface ViagemStats {
  total: number
  solicitados: number
  aprovados: number
  cancelados: number
}

// Notificação interna
export interface Notificacao {
  id: string
  tipo: ViagemStatus
  titulo: string
  mensagem: string
  lida: boolean
  criadoEm: string
  viagemId: string
}
