//
//  ReportViewController.m
//
//  Contributor(s): Ashley Lesperance, Jonas Yao, Robert Sanchez
//
//  Copyright (c) 2013 Number 123 Developer's Group
//

#import "ReportViewController.h"
#import "OverviewController.h"

@interface ReportViewController ()

@end

@implementation ReportViewController

@synthesize thePickerView, pickerViewBlocker;
@synthesize incidentSelection, severitySelection;

- (id)initWithNibName:(NSString *)nibNameOrNil bundle:(NSBundle *)nibBundleOrNil
{
    self = [super initWithNibName:nibNameOrNil bundle:nibBundleOrNil];
    if (self) {
        // Custom initialization
    }
    return self;
}

- (void)viewDidLoad
{
    NSLog(self.username);
    thePickerView.hidden = YES;
    pickerViewBlocker.hidden = YES;
    
    thePickerView.showsSelectionIndicator = TRUE;
    thePickerView.delegate = self;
    
    if(self.location != nil){
        self.locationDisplay.text = self.location;
    }
    
    NSDate *currDate = [NSDate date];
    NSDateFormatter *dateFormatter = [[NSDateFormatter alloc]init];
    [dateFormatter setDateFormat:@"dd.MM.YY HH:mm:ss"];
    NSString *dateString = [dateFormatter stringFromDate:currDate];
    self.date = dateString;
    self.dateDisplay.text = dateString;

    
    
    //initializes text field display
    self.incidentData = @"vandalism";
    self.severityData = @"information";
    self.incidentLabel.text = self.incidentData;
    self.severityLabel.text = self.severityData;
    //should be initialized when pickerview pops up
    
    
    self.incidentSelection = [[NSArray alloc] initWithObjects: @"vandalism", @"graffiti", @"person", @"property", @"other", nil];
    self.severitySelection = [[NSArray alloc] initWithObjects: @"information", @"minor", @"serious",@"critical", nil];

    
    [super viewDidLoad];
	// Do any additional setup after loading the view.
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

//*** PickerView code starts***
- (NSInteger)pickerView:(UIPickerView *)pickerView numberOfRowsInComponent:(NSInteger)component{
    
    if (component == 0){
        return [incidentSelection count];
    }
    else {
        return [severitySelection count];
    }
    
}

//number of columns/components of picker
-(NSInteger)numberOfComponentsInPickerView:(UIPickerView *)pickerView{
    
    return 2;
    
}

-(NSString *)pickerView:(UIPickerView *)pickerView titleForRow:(NSInteger)row forComponent:(NSInteger)component{
    
    if (component == 0){
        return [incidentSelection objectAtIndex:row];
        
    }
    else {
        return [severitySelection objectAtIndex:row];
        
    }
}

//returns value from pickerview
-(void)pickerView:(UIPickerView *)pickerView didSelectRow:(NSInteger)row inComponent:(NSInteger)component{
    
    if (component == 0){
        self.incidentData = [incidentSelection objectAtIndex:row];
        self.incidentLabel.text = self.incidentData;
    }
    
    else{
        self.severityData = [severitySelection objectAtIndex:row];
        self.severityLabel.text = self.severityData;
    }
    
    return;
    
}


- (IBAction)incidentButtonPressed:(id)sender {
    if (thePickerView.hidden == YES){
        thePickerView.hidden = NO;
        pickerViewBlocker.hidden = NO;
    }
}

- (IBAction)severityButtonPressed:(id)sender {
    if (thePickerView.hidden == YES){
        thePickerView.hidden = NO;
        pickerViewBlocker.hidden = NO;
    }
}

- (IBAction)doneSelection:(id)sender {
    if (thePickerView.hidden == NO){
        thePickerView.hidden = YES;
        pickerViewBlocker.hidden = YES;
    }
}

- (IBAction)buttonToOverview:(id)sender {
    
    [self performSegueWithIdentifier:@"toOverview" sender:self];
    
}

//*** PickerView code ends ***


- (BOOL) verify:(NSString *)description {
    if([description isEqualToString:@"Description"]) {
        return NO;
    }else{
        return YES;
    }
}

- (void)touchesBegan:(NSSet *)touches withEvent:(UIEvent *)event
{
    [self.view endEditing:YES];
}

- (IBAction)ImageTaker:(id)sender {
    
    UIImagePickerController *picker = [[UIImagePickerController alloc] init];
    UIImagePickerControllerSourceType sourceType = UIImagePickerControllerSourceTypePhotoLibrary;
    if([UIImagePickerController isSourceTypeAvailable:UIImagePickerControllerSourceTypeCamera]){
        sourceType = UIImagePickerControllerSourceTypeCamera;
    }
    [picker setSourceType:sourceType];
    picker.allowsEditing = NO;
    picker.delegate  = self;
    if(sourceType != UIImagePickerControllerSourceTypeCamera){
        UIAlertView *altert = [[UIAlertView alloc] initWithTitle:@"No Camera" message:@"Camera is not available" delegate:self cancelButtonTitle:@"ok" otherButtonTitles:nil];
        [altert show];
    }
    [self presentViewController:picker animated:YES completion:nil];
    
}
#pragma mark -
#pragma mark UIImagePickerControllerDelegate

- (void) imagePickerController:(UIImagePickerController *)picker didFinishPickingMediaWithInfo:(NSDictionary *)info{
    
    [self dismissViewControllerAnimated:YES completion:nil];
    UIImage *image = info[UIImagePickerControllerOriginalImage];
    _imageView.image = image;

}


-(void)prepareForSegue:(UIStoryboardSegue *)segue sender:(id)sender{

    OverviewController *overviewController = (OverviewController *)segue.destinationViewController;
    //sets value of variables from overview
    overviewController.username = self.username;
    overviewController.incidentData = self.incidentData;
    overviewController.severityData = self.severityData;
    overviewController.descriptionData = self.description.text;
    overviewController.imageData = self.imageView.image;
    overviewController.locationData = self.location;
    
}


@end
