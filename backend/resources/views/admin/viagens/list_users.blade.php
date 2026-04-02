                    @foreach($viagens as $v)
                    <tr class="trow border-b border-slate-50">
                        <td class="px-5 py-3">
                          <p class="font-mono text-xs font-semibold text-slate-400">#VGM-{{ str_pad($v->id, 4, '0', STR_PAD_LEFT) }}</p>
                          <p class="text-sm font-medium text-slate-700">{{ $v->solicitante }}</p>
                        </td>
                        <td class="px-5 py-3.5 text-sm text-slate-600">{{ $v->origem }} → {{ $v->destino }}</td>
                        <td class="px-5 py-3.5 text-xs text-slate-500 hidden md:table-cell">{{ \Carbon\Carbon::parse($v->data_ida)->format('d/m/Y') }}</td>
                        <td class="px-5 py-3.5 text-xs text-slate-500 hidden md:table-cell">{{ \Carbon\Carbon::parse($v->data_volta)->format('d/m/Y') }}</td>
                        <td class="px-5 py-3.5 text-center">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold badge-{{ $v->status }}">
                                {{ ucfirst($v->status) }}
                            </span>
                        </td>
                        <td class="px-5 py-3.5">
                            <div class="flex items-center justify-center gap-1.5">
                                
                                <button title="Ver detalhes" onclick="openDetalhe('{{ $v->id }}')" class="w-7 h-7 rounded-lg border border-slate-200 bg-white flex items-center justify-center text-slate-500 hover:border-sky-400 hover:text-sky-500 hover:bg-sky-50 transition-all">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path><path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </button>
                            
                                <button title="Aprovar" 
                                    onclick="openStatusModal({{ $v->id }}, 'aprovar', '{{ $v->solicitante }}', '{{ $v->destino }}')" 
                                    class="w-7 h-7 rounded-lg border flex items-center justify-center transition-all 
                                    {{ $v->status === 'aprovado' 
                                        ? 'bg-emerald-50 border-emerald-400 text-emerald-500 shadow-sm' 
                                        : 'bg-white border-slate-200 text-slate-500 hover:border-emerald-400 hover:text-emerald-500 hover:bg-emerald-50' 
                                    }}">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path d="M4.5 12.75l6 6 9-13.5"></path>
                                    </svg>
                                </button>

                                <button title="Cancelar" 
                                    onclick="openStatusModal({{ $v->id }}, 'cancelar', '{{ $v->solicitante }}', '{{ $v->destino }}')" 
                                    class="w-7 h-7 rounded-lg border flex items-center justify-center transition-all 
                                    {{ $v->status === 'cancelado' 
                                        ? 'bg-red-50 border-red-400 text-red-500 shadow-sm' 
                                        : 'bg-white border-slate-200 text-slate-500 hover:border-red-400 hover:text-red-500 hover:bg-red-50' 
                                    }}">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>

                                <button title="Excluir" onclick="deleteViagem({{ $v->id }})" class="w-7 h-7 rounded-lg border border-slate-200 bg-white flex items-center justify-center text-slate-500 hover:border-red-600 hover:text-red-600 hover:bg-red-50 transition-all">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                    </svg>
                                </button>

                            </div>
                        </td>
                    </tr>
                    @endforeach