const LABEL_XML = `<?xml version="1.0" encoding="utf-8"?>
<DieCutLabel Version="8.0" Units="twips" MediaType="Default">
	<PaperOrientation>Portrait</PaperOrientation>
	<Id>Small30334</Id>
	<IsOutlined>false</IsOutlined>
	<PaperName>30334 2-1/4 in x 1-1/4 in</PaperName>
	<DrawCommands>
		<RoundRectangle X="0" Y="0" Width="3240" Height="1800" Rx="270" Ry="270" />
	</DrawCommands>
	<ObjectInfo>
		<BarcodeObject>
			<Name>BARCODE</Name>
			<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />
			<BackColor Alpha="0" Red="255" Green="255" Blue="255" />
			<LinkedObjectName />
			<Rotation>Rotation0</Rotation>
			<IsMirrored>False</IsMirrored>
			<IsVariable>True</IsVariable>
			<GroupID>-1</GroupID>
			<IsOutlined>False</IsOutlined>
			<Text>REF-1234</Text>
			<Type>Code128Auto</Type>
			<Size>Medium</Size>
			<TextPosition>Bottom</TextPosition>
			<TextFont Family="Arial" Size="8" Bold="False" Italic="False" Underline="False" Strikeout="False" />
			<CheckSumFont Family="Arial" Size="8" Bold="False" Italic="False" Underline="False" Strikeout="False" />
			<TextEmbedding>None</TextEmbedding>
			<ECLevel>0</ECLevel>
			<HorizontalAlignment>Center</HorizontalAlignment>
			<QuietZonesPadding Left="0" Top="0" Right="0" Bottom="0" />
		</BarcodeObject>
		<Bounds X="228" Y="885" Width="2880" Height="720" />
	</ObjectInfo>
	<ObjectInfo>
		<TextObject>
			<Name>NOM_PRODUIT</Name>
			<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />
			<BackColor Alpha="0" Red="255" Green="255" Blue="255" />
			<LinkedObjectName />
			<Rotation>Rotation0</Rotation>
			<IsMirrored>False</IsMirrored>
			<IsVariable>True</IsVariable>
			<GroupID>-1</GroupID>
			<IsOutlined>False</IsOutlined>
			<HorizontalAlignment>Center</HorizontalAlignment>
			<VerticalAlignment>Top</VerticalAlignment>
			<TextFitMode>ShrinkToFit</TextFitMode>
			<UseFullFontHeight>True</UseFullFontHeight>
			<Verticalized>False</Verticalized>
			<StyledText>
				<Element>
					<String xml:space="preserve">10 KG de RIZ</String>
					<Attributes>
						<Font Family="Arial" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />
						<ForeColor Alpha="255" Red="0" Green="0" Blue="0" HueScale="100" />
					</Attributes>
				</Element>
			</StyledText>
		</TextObject>
		<Bounds X="888" Y="135" Width="1410" Height="255" />
	</ObjectInfo>
	<ObjectInfo>
		<TextObject>
			<Name>PRIX</Name>
			<ForeColor Alpha="255" Red="0" Green="0" Blue="0" />
			<BackColor Alpha="0" Red="255" Green="255" Blue="255" />
			<LinkedObjectName />
			<Rotation>Rotation0</Rotation>
			<IsMirrored>False</IsMirrored>
			<IsVariable>True</IsVariable>
			<GroupID>-1</GroupID>
			<IsOutlined>False</IsOutlined>
			<HorizontalAlignment>Center</HorizontalAlignment>
			<VerticalAlignment>Top</VerticalAlignment>
			<TextFitMode>ShrinkToFit</TextFitMode>
			<UseFullFontHeight>True</UseFullFontHeight>
			<Verticalized>False</Verticalized>
			<StyledText>
				<Element>
					<String xml:space="preserve">Prix : 9,99€</String>
					<Attributes>
						<Font Family="Arial" Size="12" Bold="False" Italic="False" Underline="False" Strikeout="False" />
						<ForeColor Alpha="255" Red="0" Green="0" Blue="0" HueScale="100" />
					</Attributes>
				</Element>
			</StyledText>
		</TextObject>
		<Bounds X="903" Y="480" Width="1560" Height="270" />
	</ObjectInfo>
</DieCutLabel>`;


// je Récupérer les éléments du DOM
const reference = document.getElementById('reference');
const nomProduit = document.getElementById('nomProduit');
const prix = document.getElementById('prix');
const previewZone = document.getElementById('previewZone');
const printBtn = document.getElementById('printBtn');
const saveBtn = document.getElementById('saveBtn');
const printerSelect = document.getElementById('printerSelect');

// le modèle 
function openLabel() {
  return dymo.label.framework.openLabelXml(LABEL_XML);
}

// Mettre à jour les valeurs de l’étiquette avec les données du formulaire

function updateLabelValues(label) {
  label.setObjectText('BARCODE', reference.value);
  label.setObjectText('NOM_PRODUIT', nomProduit.value);
  label.setObjectText('PRIX', prix.value);
}

    // Charger les imprimantes DYMO disponibles
function loadPrinters() {
  try {
    const printers = dymo.label.framework.getPrinters() || [];
    const dymoPrinters = printers.filter(p => p.printerType.toLowerCase().includes('labelwriter'));
    printerSelect.innerHTML = "";
    if(dymoPrinters.length === 0){
      const option = document.createElement('option');
      option.value = "";
      option.textContent = "Aucune imprimante trouvée";
      printerSelect.appendChild(option);
      return;
    }
    dymoPrinters.forEach(p => {
      const option = document.createElement('option');
      option.value = p.name;
      option.textContent = p.name;
      printerSelect.appendChild(option);
    });
  } catch(e){
    console.error("Erreur chargement imprimantes :", e);
  }
}

// Générer l’aperçu de l’étiquette à chaque modification des champ

function renderPreview() {
  try {
    const label = openLabel();
    updateLabelValues(label);

    const pngData = label.render("", "");
    previewZone.innerHTML = "";
    const img = document.createElement("img");
    img.src = "data:image/png;base64," + pngData;
    previewZone.appendChild(img);
  } catch (e) {
    previewZone.innerHTML = "Impossible de générer l’aperçu.";
    console.error(e);
  }
}

// Imprimer l’étiquette

function printLabel() {
  try {
    const printerName = printerSelect.value;
    if(!printerName) {
      alert("Sélectionnez une imprimante DYMO !");
      return;
    }

    const label = openLabel();
    updateLabelValues(label);
    label.print(printerName, "", "");
  } catch(e) {
    console.error("Erreur d’impression :", e);
  }
}
// Initialisation au chargement de la page

document.addEventListener("DOMContentLoaded", () => {
  dymo.label.framework.init(() => {
    loadPrinters();
    renderPreview();
  });

  reference.addEventListener('input', renderPreview);
  nomProduit.addEventListener('input', renderPreview);
  prix.addEventListener('input', renderPreview);

  printBtn.addEventListener('click', printLabel);
  saveBtn.addEventListener('click', printLabel);
});