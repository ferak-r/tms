<?php
include("lib/site.module.php");

$user = new USER();

$db->query('TRUNCATE TABLE xxuser_action');
$db->query('TRUNCATE TABLE xxuser_groupaction');

$cnt = 1;

echo "<pre>\n\n\n";

print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'index', ''));											#1

//### section = account
print("\n".($cnt++).":\t".$user->manageAction('add', 'account', 'account-admin', 'add'));								#2
print("\n".($cnt++).":\t".$user->manageAction('add', 'account', 'account-admin', 'update'));							#3
print("\n".($cnt++).":\t".$user->manageAction('add', 'account', 'account-admin', 'delete'));							#4
print("\n".($cnt++).":\t".$user->manageAction('add', 'account', 'account-admin', ''));									#5
print("\n".($cnt++).":\t".$user->manageAction('add', 'account', 'account-list', ''));									#6

//### section = admin
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'carrier-admin', 'add'));									#7
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'carrier-admin', 'update'));								#8
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'carrier-admin', 'delete'));								#9
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'carrier-admin', ''));									#10
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'carrier-admin', 'add', 'equipment'));					#11
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'carrier-admin', 'update', 'equipment'));					#12
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'carrier-admin', 'delete', 'equipment'));					#13
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'carrier-admin', '', 'equipment'));						#14
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'carrier-list', ''));										#15
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'carrier-detail', ''));									#16

print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'combo-admin', 'add'));									#17
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'combo-admin', 'update'));								#18
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'combo-admin', 'delete'));								#19
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'combo-admin', ''));										#20
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'combo-list', ''));										#21

print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'container-admin', 'add'));								#22
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'container-admin', 'update'));							#23
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'container-admin', 'delete'));							#24
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'container-admin', ''));									#25
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'container-list', ''));									#26
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'container-detail', ''));									#27

print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'container-lend-admin', 'add'));							#28
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'container-lend-admin', 'update'));						#29
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'container-lend-admin', 'delete'));						#30
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'container-lend-admin', ''));								#31
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'container-lend-list', ''));								#32

print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'container-status', 'update'));							#33
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'container-status', ''));									#34

print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'customer-admin', 'add'));								#35
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'customer-admin', 'update'));								#36
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'customer-admin', 'delete'));								#37
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'customer-admin', ''));									#38
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'customer-list', ''));									#39

print("\n".($cnt++).":\t".$user->manageAction('add', 'account', 'customs-admin', 'update'));							#40
print("\n".($cnt++).":\t".$user->manageAction('add', 'account', 'customs-admin', 'del_img'));							#41
print("\n".($cnt++).":\t".$user->manageAction('add', 'account', 'customs-list', ''));									#42

print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'equipment-admin', 'add'));								#43
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'equipment-admin', 'update'));							#44
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'equipment-admin', 'delete'));							#45
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'equipment-admin', ''));									#46
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'equipment-list', ''));									#47
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'equipment-detail', ''));									#48

print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'office-admin', 'add'));									#49
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'office-admin', 'update'));								#50
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'office-admin', 'delete'));								#51
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'office-admin', ''));										#52
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'office-list', ''));										#53

print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'partyaccount-detail', ''));								#54

print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'user-admin', 'add'));									#55
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'user-admin', 'update'));									#56
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'user-admin', 'delete'));									#57
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'user-admin', ''));										#58
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'user-list', ''));										#59

print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'user-changepass', 'changepass'));						#60
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'user-changepass', ''));									#61

//### section = carrier
print("\n".($cnt++).":\t".$user->manageAction('add', 'carrier', 'loading-admin', 'add', 'path'));						#62
print("\n".($cnt++).":\t".$user->manageAction('add', 'carrier', 'loading-admin', 'update', 'path'));					#63
print("\n".($cnt++).":\t".$user->manageAction('add', 'carrier', 'loading-admin', 'delete', 'path'));					#64
print("\n".($cnt++).":\t".$user->manageAction('add', 'carrier', 'loading-admin', '', 'path'));							#65
print("\n".($cnt++).":\t".$user->manageAction('add', 'carrier', 'loading-admin', 'add', 'loading'));					#66
print("\n".($cnt++).":\t".$user->manageAction('add', 'carrier', 'loading-admin', 'update', 'loading'));					#67
print("\n".($cnt++).":\t".$user->manageAction('add', 'carrier', 'loading-admin', 'delete', 'loading'));					#68
print("\n".($cnt++).":\t".$user->manageAction('add', 'carrier', 'loading-admin', '', 'loading'));						#69

//### section = operation
print("\n".($cnt++).":\t".$user->manageAction('add', 'operation', 'cargodocument-admin', 'add'));						#70
print("\n".($cnt++).":\t".$user->manageAction('add', 'operation', 'cargodocument-admin', 'update'));					#71
print("\n".($cnt++).":\t".$user->manageAction('add', 'operation', 'cargodocument-admin', 'delete'));					#72
print("\n".($cnt++).":\t".$user->manageAction('add', 'operation', 'cargodocument-admin', 'del_img'));					#73
print("\n".($cnt++).":\t".$user->manageAction('add', 'operation', 'cargodocument-admin', ''));							#74

print("\n".($cnt++).":\t".$user->manageAction('add', 'operation', 'operation-admin', 'update'));						#75
print("\n".($cnt++).":\t".$user->manageAction('add', 'operation', 'operation-admin', ''));								#76

print("\n".($cnt++).":\t".$user->manageAction('add', 'operation', 'transport-admin', 'add', 'transport'));				#77
print("\n".($cnt++).":\t".$user->manageAction('add', 'operation', 'transport-admin', 'update', 'transport'));			#78
print("\n".($cnt++).":\t".$user->manageAction('add', 'operation', 'transport-admin', 'delete', 'transport'));			#79
print("\n".($cnt++).":\t".$user->manageAction('add', 'operation', 'transport-admin', '', 'transport'));					#80
print("\n".($cnt++).":\t".$user->manageAction('add', 'operation', 'transport-admin', 'add', 'document'));				#81
print("\n".($cnt++).":\t".$user->manageAction('add', 'operation', 'transport-admin', 'update', 'document'));			#82
print("\n".($cnt++).":\t".$user->manageAction('add', 'operation', 'transport-admin', 'delete', 'document'));			#83
print("\n".($cnt++).":\t".$user->manageAction('add', 'operation', 'transport-admin', 'deleteimg', 'document'));			#84
print("\n".($cnt++).":\t".$user->manageAction('add', 'operation', 'transport-admin', '', 'document'));					#85
print("\n".($cnt++).":\t".$user->manageAction('add', 'operation', 'transport-admin', 'add', 'documentcomment'));		#86
print("\n".($cnt++).":\t".$user->manageAction('add', 'operation', 'transport-admin', 'update', 'documentcomment'));		#87
print("\n".($cnt++).":\t".$user->manageAction('add', 'operation', 'transport-admin', 'delete', 'documentcomment'));		#88
print("\n".($cnt++).":\t".$user->manageAction('add', 'operation', 'transport-admin', '', 'documentcomment'));			#89
print("\n".($cnt++).":\t".$user->manageAction('add', 'operation', 'transport-admin', 'add', 'cargo'));					#90
print("\n".($cnt++).":\t".$user->manageAction('add', 'operation', 'transport-admin', 'update', 'cargo'));				#91
print("\n".($cnt++).":\t".$user->manageAction('add', 'operation', 'transport-admin', '', 'cargo'));						#92
print("\n".($cnt++).":\t".$user->manageAction('add', 'operation', 'transport-admin', 'add', 'cargo', 'Container'));		#93
print("\n".($cnt++).":\t".$user->manageAction('add', 'operation', 'transport-admin', 'update', 'cargo', 'Container'));	#94
print("\n".($cnt++).":\t".$user->manageAction('add', 'operation', 'transport-admin', 'delete', 'cargo', 'Container'));	#95
print("\n".($cnt++).":\t".$user->manageAction('add', 'operation', 'transport-admin', '', 'cargo', 'Container'));		#96
print("\n".($cnt++).":\t".$user->manageAction('add', 'operation', 'transport-admin', 'add', 'containercargo'));			#97
print("\n".($cnt++).":\t".$user->manageAction('add', 'operation', 'transport-admin', 'update', 'containercargo'));		#98
print("\n".($cnt++).":\t".$user->manageAction('add', 'operation', 'transport-admin', 'delete', 'containercargo'));		#99
print("\n".($cnt++).":\t".$user->manageAction('add', 'operation', 'transport-admin', '', 'containercargo'));			#100
print("\n".($cnt++).":\t".$user->manageAction('add', 'operation', 'transport-list', '', 'transport'));					#101
print("\n".($cnt++).":\t".$user->manageAction('add', 'operation', 'transport-list', '', 'document'));					#102
print("\n".($cnt++).":\t".$user->manageAction('add', 'operation', 'transport-detail', ''));								#103
print("\n".($cnt++).":\t".$user->manageAction('add', 'operation', 'transportcargo-detail', ''));						#104
print("\n".($cnt++).":\t".$user->manageAction('add', 'operation', 'transportcontainer-detail', ''));					#105

//### section = user
print("\n".($cnt++).":\t".$user->manageAction('add', 'user', 'mail-admin', 'download'));								#106
print("\n".($cnt++).":\t".$user->manageAction('add', 'user', 'mail-admin', 'view'));									#107
print("\n".($cnt++).":\t".$user->manageAction('add', 'user', 'mail-admin', 'save'));									#108
print("\n".($cnt++).":\t".$user->manageAction('add', 'user', 'mail-admin', 'send'));									#109
print("\n".($cnt++).":\t".$user->manageAction('add', 'user', 'mail-admin', 'delete'));									#110
print("\n".($cnt++).":\t".$user->manageAction('add', 'user', 'mail-admin', 'edit'));									#111
print("\n".($cnt++).":\t".$user->manageAction('add', 'user', 'mail-admin', ''));										#112
print("\n".($cnt++).":\t".$user->manageAction('add', 'user', 'mail-list', ''));											#113

print("\n".($cnt++).":\t".$user->manageAction('add', 'user', 'mail-receiver', 'add'));									#114
print("\n".($cnt++).":\t".$user->manageAction('add', 'user', 'mail-receiver', ''));										#115

print("\n".($cnt++).":\t".$user->manageAction('add', 'user', 'reminder-admin', 'add'));									#116
print("\n".($cnt++).":\t".$user->manageAction('add', 'user', 'reminder-admin', 'update'));								#117
print("\n".($cnt++).":\t".$user->manageAction('add', 'user', 'reminder-admin', 'alert'));								#118
print("\n".($cnt++).":\t".$user->manageAction('add', 'user', 'reminder-admin', 'postpone'));							#119
print("\n".($cnt++).":\t".$user->manageAction('add', 'user', 'reminder-admin', 'delete'));								#120
print("\n".($cnt++).":\t".$user->manageAction('add', 'user', 'reminder-admin', ''));									#121
print("\n".($cnt++).":\t".$user->manageAction('add', 'user', 'reminder-list', ''));										#122

//### extras
print("\n".($cnt++).":\t".$user->manageAction('add', 'account', 'customs-admin', ''));									#123
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'combo-admin', 'combooutput'));							#124

print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'carrier-admin', 'add', 'carrier'));						#125
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'carrier-admin', 'update', 'carrier'));					#126
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'carrier-admin', 'delete', 'carrier'));					#127
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'carrier-admin', '', 'carrier'));							#128

print("\n".($cnt++).":\t".$user->manageAction('add', 'carrier', 'loading-equipment-detail', '')); 						#129

print("\n".($cnt++).":\t".$user->manageAction('add', 'operation', 'transport-admin', 'docoutput', 'document')); 		#130
print("\n".($cnt++).":\t".$user->manageAction('add', 'operation', 'transport-admin', 'cargooutput', 'document')); 		#131
print("\n".($cnt++).":\t".$user->manageAction('add', 'carrier', 'loading-admin', 'pathoutput', 'path')); 				#132
print("\n".($cnt++).":\t".$user->manageAction('add', 'operation', 'cargodocument-admin', 'docoutput')); 				#133
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'carrier-admin', 'equipmentoutput', 'equipment')); 		#134

print("\n".($cnt++).":\t".$user->manageAction('add', 'operation', 'transport-admin', 'add', 'cargo', 'Bulk'));			#135
print("\n".($cnt++).":\t".$user->manageAction('add', 'operation', 'transport-admin', 'update', 'cargo', 'Bulk'));		#136
print("\n".($cnt++).":\t".$user->manageAction('add', 'operation', 'transport-admin', '', 'cargo', 'Bulk'));				#137

print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'me', ''));												#138

print("\n".($cnt++).":\t".$user->manageAction('add', 'operation', 'transport-admin', 'cargodocument', 'finished'));		#139
print("\n".($cnt++).":\t".$user->manageAction('add', 'operation', 'transport-admin', 'transportdocument', 'finished'));	#140
print("\n".($cnt++).":\t".$user->manageAction('add', 'operation', 'transport-admin', 'accounting', 'finished'));		#141
print("\n".($cnt++).":\t".$user->manageAction('add', 'operation', 'transport-admin', 'customs', 'finished'));			#142
print("\n".($cnt++).":\t".$user->manageAction('add', 'operation', 'transport-admin', 'operation', 'finished'));			#143

print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'exportdb', ''));											#144
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'importdb', ''));											#145	
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'importdb', 'import'));									#146

print("\n".($cnt++).":\t".$user->manageAction('add', 'user', 'mail-list', 'inbox'));									#147
print("\n".($cnt++).":\t".$user->manageAction('add', 'user', 'mail-list', 'sent'));										#148
print("\n".($cnt++).":\t".$user->manageAction('add', 'user', 'mail-list', 'draft'));									#149

print("\n".($cnt++).":\t".$user->manageAction('add', 'account', 'account-admin', 'deleteimg'));							#150

print("\n".($cnt++).":\t".$user->manageAction('add', 'operation', 'transport-admin', 'documentation', 'finished'));		#151

print("\n".($cnt++).":\t".$user->manageAction('add', 'user', 'mail-admin', 'newmail'));									#152

print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'statuscolor-admin', 'add'));								#153
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'statuscolor-admin', 'update'));							#154
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'statuscolor-admin', 'delete'));							#155
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'statuscolor-admin', ''));								#156
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'statuscolor-list', ''));									#157

print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'report-admin', 'delete'));								#158
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'report-admin', 'result'));								#159
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'report-admin', 'favorresult'));							#160
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'report-admin', ''));										#161
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'report-list', ''));										#162
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'report-list', 'favor'));									#163

print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'reportmaker-admin', 'add'));								#164
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'reportmaker-admin', 'delete'));							#165
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'reportmaker-admin', ''));								#166
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'reportmaker-list', ''));									#167

print("\n".($cnt++).":\t".$user->manageAction('add', 'operation', 'status-admin', 'update'));							#168
print("\n".($cnt++).":\t".$user->manageAction('add', 'operation', 'status-admin', ''));									#169

print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'container-status-all', 'update'));						#170
print("\n".($cnt++).":\t".$user->manageAction('add', 'admin', 'container-status-all', ''));								#171


//#######
print("\nadmin:\t".$user->manageGroup('add', 'admin', array(1
															,2,3,4,5,6,7,8,9,10 
															,11,12,13,14,15,16,17 
															,18,19,20,21,22,23,24
															,25,26,27,28,29,30,31
															,32,33,34,35,36,37,38
															,39,40,41,42,43,44,45
															,46,47,48,49,50,51,52
															,53,54,55,56,57,58,59
															,60,61,62,63,64,65,66
															,67,68,69,70,71,72,73
															,74,75,76,77,78,79,80
															,81,82,83,84,85,86,87
															,88,89,90,91,92,93,94
															,95,96,97,98,99,100,101
															,102,103,104,105,106,107,108
															,109,110,111,112,113,114,115
															,116,117,118,119,120,121,122
															,123,124,125,126,127,128,129,130
															,131,132,133,134,135,136,137,138
															,139,140,141,142,143
															,144,145,146
															,147,148,149
															,150,151,152
															,153,154,155,156,157
															,158,159,160,161,162,163
															,164,165,166,167
															,168,169
															,170,171)));
															
print("\naccount:\t".$user->manageGroup('add','account&customs',array(1
														  ,2,3,4,5,6
														  ,10,14,15,16,20,21
														  ,22,23,24,25,26,27
														  ,31,32,34,38,39
														  ,40,41,42
														  ,46,47,48
														  ,52,53,54,58,59,61,65,69
														  ,74,76,80,85,89,92,96,100,101,102
														  ,103,104,105
														  ,106,107,108,109,110,111,112,113,114,115
														  ,116,117,118,119,120,121,122,123,128,129
														  ,101,123,137,141,142
														  ,147,148,149
														  ,150,152
														  ,153,154,155,156,157
														  ,158,159,160,161,162,163
														  ,168,169
														  ,170,171)));

print("\ncarrier:\t".$user->manageGroup('add', 'carrier', array(
															1
															,5,6
															,7,8,9,10,11,12,13,14,15,16
															,20,21,25,26,27
															,31,32,33,34,38,39
															,42,43,44,45,46,47,48
															,52,53,54,58,59
															,61,62,63,64,65,66,67,68,69
															,70,71,72,73,74,76
															,80,85,89,92,96
														  	,100,101,102,103,104,105,106,107,108,109,110,111,112,113,114,115
														  	,116,117,118,119,120,121,122,123
															,125,126,127,128,129,132,137
															,147,148,149,152
															,153,154,155,156,157
															,158,159,160,161,162,163
															,168,169
															,170,171)));
																					
print("\noperation:\t".$user->manageGroup('add', 'operation', array(
															 1
															 ,5,6
															 ,7,8,9,10,11,12,13,14,15,16
															 ,17,18,19,20,21
															 ,22,23,24,25,26,27
															 ,28,29,30,31,32,33,34,38,39
															 ,40,41,42,43,44,45,46,47,48
															 ,52,53,54,58,59,61,65,69
															 ,70,71,72,73,74,75,76
															 ,77,78,79,80,85,89,90
															 ,91,92,93,94,95,96,97
															 ,98,99,100,101,102,103,104,105
														  	 ,106,107,108,109,110,111,112,113,114,115
														  	 ,116,117,118,119,120,121,122,123,124
															 ,125,126,127,128,129
															 ,130,131,132,133,134,135,136,137,138
														  	 ,101,143
															 ,147,148,149,152
															 ,62,63,64,66,67,68
															 ,153,154,155,156,157
															 ,158,159,160,161,162,163
															 ,168,169
															 ,170,171)));
															 

print("\ndocument:\t".$user->manageGroup('add', 'document', array(
															 1
															 ,5,6,7,8,9,10,11,12,13,14,15,16
															 ,17,18,19,20,21
															 ,22,23,24,25,26,27
															 ,31,32,34,35,36,37,38,39
															 ,42,46,47,48,49,50,51,52,53,54,58,59
															 ,61,65,69
															 ,70,71,72,73,74,75,76
															 ,77,78,79,80,81,82,83
															 ,84,85,86,87,88,89,90
															 ,91,92,93,94,95,96,97
															 ,98,99,100,101,102,103,104,105
														  	 ,106,107,108,109,110,111,112,113,114,115
														  	 ,116,117,118,119,120,121,122,123,124
															 ,125,126,127,128,129
															 ,130,131,132,133,134
															 ,135,136,137,139,140
															 ,147,148,149,151,152
															 ,153,154,155,156,157
															 ,158,159,160,161,162,163
															 ,168,169
															 ,170,171)));

print("\noffice:\t".$user->manageGroup('add', 'office', array(
															 1
															 ,48,103,104,105,129
														  	 ,101
															 ,158,159,160,161,162,163
															 ,168,169
															 ,170,171)));

print("\ncustomer:\t".$user->manageGroup('add', 'customer', array(
															 1
															 ,48,103,104,105,129
														  	 ,101
															 ,158,159,160,161,162,163
															 ,168,169
															 ,170,171)));

print("\nwebcarrier:\t".$user->manageGroup('add', 'webcarrier', array(
															 1
															 ,48,103,104,105,129
														  	 ,101
															 ,158,159,160,161,162,163
															 ,168,169
															 ,170,171)));

																					
echo "</pre>";
trace($user->checkPermision('admin' , 'carrier-admin', 'add'));
?>