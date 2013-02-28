//
//  ReportViewController.m
//  peaceguard
//
//  Created by JonasYao on 2013-02-15.
//  Copyright (c) 2013 Ashley Lesperance. All rights reserved.
//

#import "ReportViewController.h"

@interface ReportViewController ()

@end

@implementation ReportViewController

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
    [super viewDidLoad];
	// Do any additional setup after loading the view.
}

- (void)didReceiveMemoryWarning
{
    [super didReceiveMemoryWarning];
    // Dispose of any resources that can be recreated.
}

- (IBAction)submitAction:(id)sender {
    BOOL verification = [self verify:self.description.text];
    if(verification == YES){
        [self performSegueWithIdentifier:@"ToOverView" sender:self];
    }else{
        UIAlertView *alert = [[UIAlertView alloc] initWithTitle:@"Submit failed"
                                                        message:@"The description is null."
                                                       delegate:nil
                                              cancelButtonTitle:@"OK"
                                              otherButtonTitles:nil];
        [alert show];
    }
}

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
    @try {
        UIImagePickerController *picker = [[UIImagePickerController alloc] init];
        picker.sourceType = UIImagePickerControllerSourceTypeCamera;
        picker.delegate = self;
    }
    @catch (NSException *exception) {
        UIAlertView *altert = [[UIAlertView alloc] initWithTitle:@"No Camera" message:@"Camera is not available" delegate:self cancelButtonTitle:@"ok" otherButtonTitles:nil];
        [altert show];
    }
}
- (void) imagePickerController:(UIImagePickerController *)picker didFinishPickingMediaWithInfo:(NSDictionary *)info{
    
    [picker dismissViewControllerAnimated:YES completion:nil];
    UIImageView *imgview1 = [[UIImageView alloc]initWithImage:[info objectForKey:@"UIImagePickerControllerOriginalImage"]];
    imgview1.frame = CGRectMake(0.0, 0.0, 320.0, 460.0);
    [self.view addSubview:imgview1];
}
@end
