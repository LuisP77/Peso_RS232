unit Unit1;

{$mode objfpc}{$H+}

interface

uses
  Classes, SysUtils, sqldb, mysql56conn, mysql50conn, mysql55conn, mysql51conn,
  db, FileUtil, LazSerial, Forms, Controls, Graphics, Dialogs, StdCtrls,
  ExtCtrls, StrUtils;

type

  { TForm1 }

  TForm1 = class(TForm)
    Button1: TButton;
    Button2: TButton;
    DataSource1: TDataSource;
    Edit1: TEdit;
    LazSerial1: TLazSerial;
    SQLConnector1: TSQLConnector;
    SQLQuery1: TSQLQuery;
    SQLTransaction1: TSQLTransaction;
    procedure Button1Click(Sender: TObject);
    procedure Button2Click(Sender: TObject);
    procedure LazSerial1RxData(Sender: TObject);
  private
    { private declarations }
  public
    { public declarations }
  end;

var
  Form1: TForm1;

implementation

{$R *.lfm}

{ TForm1 }

procedure TForm1.Button1Click(Sender: TObject);
begin
  LazSerial1.ShowSetupDialog;
  try
     LazSerial1.Open;
     Edit1.Text := 'Conectado';
  except
     On E :Exception do begin
       ShowMessage(  E.Message);
     end;
  end;
end;

procedure TForm1.Button2Click(Sender: TObject);
begin
  LazSerial1.Close;
  Edit1.Text := 'Desconectado';
end;

procedure TForm1.LazSerial1RxData(Sender: TObject);
var
 i:word;
 weight:real;
 S,sql,peso : string;
begin
  S := LazSerial1.ReadData;
  if AnsiStartsStr('Weight',S) then begin
     peso := '';
     for i:=1 to length(S) do
       if (S[i] in ['0'..'9','.']) then begin
         if S[i]='.' then S[i]:=DecimalSeparator;
         peso := peso + S[i];
       end;

     peso := Trim(peso);
     weight := 1000*StrToFloat(peso);
     peso := floatToStr(weight);
     Edit1.Text := peso;

//------------------------------------------------------------------------------
try
  SQLConnector1.Connected := false;
  SQLTransaction1.Active:= false;
  SQLQuery1.Active := false;
  DataSource1.Enabled:=true;

  with SQLConnector1 do begin
    ConnectorType := 'MySQL 5.6';
    HostName := '31.220.20.208';
    DatabaseName := 'u390183179_tysaz';
    UserName := 'u390183179_vadur';
    Password := 'puXaXuBaGe';

//        HostName := 'www.elcomprador.cat';
//        DatabaseName := 'supermercat_alpha';
//        UserName := 'super_alpha';
//        Password := 'yJqfunvHFME28cEd';
    Transaction := SQLTransaction1;
    Connected := true;
  end;

  with SQLTransaction1 do begin
    Database := SQLConnector1;
    Active := True;
  end;

  with SQLQuery1 do begin
    Database := SQLConnector1;
    Transaction := SQLTransaction1;
    SQL.Text := 'SET CHARACTER SET '+ QuotedStr('utf8');
    ExecSQL;
    SQLTransaction1.Commit;
    SQL.Text := 'SET NAMES '+ QuotedStr('utf8');
    ExecSQL;
    SQLTransaction1.Commit;
  end;

  //ShowMessage('Conectado exitosamente');

except
 On E :Exception do begin
   ShowMessage( E.Message);
 end;
end;

//------------------------------------------------------------------------------

    sql := 'UPDATE u390183179_tysaz.peso SET  peso = '+ peso;
    try
      SQLQuery1.SQL.Text := sql;
      SQLQuery1.ExecSQL;
      SQLTransaction1.Commit;
    except
      MessageDlg('Error al enviar PESO' , mtError, [mbOK], 0);
    end;

  end;
end;

end.

