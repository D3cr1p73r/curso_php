create table CAD_SOLICITACOES
(
  codigo          NUMBER not null,
  anvisa          VARCHAR2(30),
  fornecedor      NUMBER(9),
  cod_agenda_ccir NUMBER(9),
  nome_medico     VARCHAR2(100),
  status          NUMBER default 0,
  prioridade      NUMBER,
  usuario         VARCHAR2(30),
  dt_solic        DATE default SYSDATE,
  anexo           VARCHAR2(400)
);
CREATE TABLE CAD_SOLICITACOES_CONTROLE
(
    COD_SOLICITACAO NUMBER NOT NULL,   
    SEQUENCIA       NUMBER NOT NULL,       
    STATUS          NUMBER,
    OBSERVACAO      VARCHAR(400),
    USUARIO         VARCHAR(30) NOT NULL,
    DT_CONTROLE     DATE DEFAULT SYSDATE
);