

   SET NOCOUNT ON;
   DECLARE @ruta AS NVARCHAR(100)
   DECLARE @ruta2 AS NVARCHAR(100)
   
   SET @ruta = 'D:\RespaldosComunicados\COMUNICADOS_' 
                        + CAST(DATEPART(DAY,getdate()) AS VARCHAR(10)) 
                        + CAST(DATENAME(MONTH ,getdate()) AS VARCHAR(10)) 
                        + CAST(DATEPART(YEAR ,getdate()) AS VARCHAR(10)) + '.bak'  
   BACKUP DATABASE COMUNICADOS TO DISK = @ruta

   SET @ruta2 = 'D:\RespaldosComunicados\Gestion_Entrevistas_' 
							+ CAST(DATEPART(DAY,getdate()) AS VARCHAR(10)) 
							+ CAST(DATENAME(MONTH ,getdate()) AS VARCHAR(10)) 
							+ CAST(DATEPART(YEAR ,getdate()) AS VARCHAR(10)) + '.bak'  
   BACKUP DATABASE GestionEntrevistas TO DISK = @ruta2

   GO
